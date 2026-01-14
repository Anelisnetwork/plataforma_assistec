var mail_pat = /^[A-Za-z\u00F1\u00D10-9_.\-][A-Za-z\u00F1\u00D10-9_.\-]*@[A-Za-z\u00F1\u00D10-9_\-]+\.[A-Za-z\u00F1\u00D10-9_.]+[A-za-z\u00F1\u00D1]$/;
var pass_pat = /^[0-9-A-z\u00F1\u00D1_@$&]*$/;
var ext_img = ['jpg','png','gif'];

function moneda_float(valor){//convierte un valor del tipo 12.450,85 a un float válido 12450.85
	return parseFloat(valor.replace('.', '').replace(',', '.'));
}

function drawChart_linear(contenido, dato, titulo, contenedor){
	$.ajax({
		type: "POST",
		url: "base_ajax/",
		data: {contenido:contenido, dato:dato},
		dataType: "json"
	}).done(function(jsonData) {
		var data = new google.visualization.DataTable(jsonData);
		var options = {
			title: titulo,
			'chartArea': {'width': '80%', 'height': '60%'},
			legend: { position: 'none' }
		};
		var chart = new google.visualization.LineChart(document.getElementById(contenedor));
		chart.draw(data, options);
	}).fail(function() {
		$("#"+contenedor).html('<div style="text-align:center; padding:60px">No hay datos</div>');
	});
}

function drawChart_columnas(contenido, dato, titulo, contenedor){
	$.ajax({
		type: "POST",
		url: "base_ajax/",
		data: {contenido:contenido, dato:dato},
		dataType: "json"
	}).done(function(jsonData) {
		var data = new google.visualization.DataTable(jsonData);
		var options = {
			title: titulo,
			'chartArea': {'width': '80%', 'height': '60%'},
			legend: { position: 'none' }
		};
		var chart = new google.visualization.ColumnChart(document.getElementById(contenedor));
		chart.draw(data, options);
	}).fail(function() {
		$("#"+contenedor).html('<div style="text-align:center; padding:60px">No hay datos</div>');
	});
}

function drawChart_columnas_img(contenido, dato, titulo, contenedor){
	//alert ('hola');
	$.ajax({
		type: "POST",
		url: "base_ajax/",
		data: {contenido:contenido, dato:dato},
		dataType: "json"
	}).done(function(jsonData) {
		var data = new google.visualization.DataTable(jsonData);
		var options = {
			title: titulo,
			'chartArea': {'width': '80%', 'height': '60%'},
			legend: { position: 'none' }
		};
		var chart = new google.visualization.ColumnChart(document.getElementById(contenedor));
		google.visualization.events.addListener(chart, 'ready', function ()      {
         contenedor.innerHTML = '<img src="' + chart.getImageURI() + '">';
        });
		chart.draw(data, options);
	}).fail(function() {
		$("#"+contenedor).html('<div style="text-align:center; padding:60px">No hay datos</div>');
	});
}

function drawChart_columnas_legend(contenido, dato, titulo, contenedor){
	$.ajax({
		type: "POST",
		url: "base_ajax/",
		data: {contenido:contenido, dato:dato},
		dataType: "json"
	}).done(function(jsonData) {
		var data = new google.visualization.DataTable(jsonData);
		var options = {
			title: titulo,
			'chartArea': {'width': '80%', 'height': '60%'},
			legend: { position: 'bottom' }
		};
		var chart = new google.visualization.ColumnChart(document.getElementById(contenedor));
		chart.draw(data, options);
	}).fail(function() {
		$("#"+contenedor).html('<div style="text-align:center; padding:60px">No hay datos</div>');
	});
}

function hacer_autobusq(campo){
	$( '#'+campo ).autocomplete({
		source: function (request, response) {
			contenido='ajax_busca_talleres';
			$.ajax({
				dataType: 'json',
				type: "POST",
				url: "base_ajax/",
				data: {contenido:contenido, term: request.term},
				success: function (data) {
					//res=$('#data' , data).html();
					response($.map(data, function (item) {
						return {
							label: item.ta_nombre,
							value: item.ta_nombre,
							idtaller: item.ta_idtaller,
							idtipo: item.ta_idtipo
						}
					}));
					//console.log(data);
				},
				error: function (data) {
					//alert('error '+data);
					console.log(data);
				}
			});
			 
		},
		//source: lista_referencias,
		minLength: 3,
		autoFocus: true,
		//change: function( event, ui ) {console.log(ui)}
		change: function( event, ui ) {
			if(ui['item']==null){
				$( '#'+campo ).val('');
				$("#f_id_taller").val('');
				$("#f_tipo_taller").val(1);
				actualiza_busqueda_taller('');
				//vacio_borra(campo)
			}
		},
		select: function( event, ui ) {
			if(ui['item']==null){
				$( '#'+campo ).val('');
				$("#f_id_taller").val('');
				$("#f_tipo_taller").val(1);
				actualiza_busqueda_taller('');
				//vacio_borra(campo)
			}
			else{
				$("#f_id_taller").val(ui['item']['idtaller']);
				$("#f_tipo_taller").val(ui['item']['idtipo']);
				actualiza_busqueda_taller(ui['item']['value']);
				//alert(ui['item']['idtaller']);
			}
		},
		close: function( event, ui ) {
			return false;
		}
	});
}

$(document).ready(function() {
	// SECCIÓN DE LISTADOS
	hacer_autobusq('f_nombre_taller');
	$( "#f_nombre_taller" ).keyup(function() {
		if($(this).val().length<3){
			$("#f_id_taller").val('');
			$("#f_tipo_taller").val(1);
			actualiza_busqueda_taller('');
		}
	});
	$("#f_tipo_taller").change(function() {
		//alert($(this).val());
		$("#f_nombre_taller").val('');
		$("#f_id_taller").val('');
		actualiza_busqueda_taller('');
	});
	$("#f_prov_todas").click(function() {
		marcado=$(this).prop('checked');
		$('.porprov').each(function(){
			$(this).prop('checked', marcado);
		});
		actualiza_busqueda_provincia();
	});
	$(".porprov").click(function() {
		todas=true;
		$('.porprov').each(function(){
			!$(this).prop('checked')?todas=false:'';
		});
		$("#f_prov_todas").prop('checked', todas);
		actualiza_busqueda_provincia();
	});
	$(".pormes").click(function() {
		vacio=true;
		este=this.id;
		//alert(este);
		$('.pormes').each(function(){
			$(this).prop('checked')?vacio=false:'';
		});
		vacio==true?$("#"+este).prop('checked', true):'';
		actualiza_busqueda_pormes();
	});
	$("#f_anho").change(function() {
		actualiza_busqueda_pormes();
	});
	$("#excel_listados").submit(function() {
		hay_tipos=false;
		$('.sel_tipoinf').each(function(){
			$(this).prop('checked')?hay_tipos=true:'';
		});
		hay_taller=$('#f_id_taller').val()!='';
		hay_meses=false;
		$('.pormes').each(function(){
			$(this).prop('checked')?hay_meses=true:'';
		});

		if(!hay_tipos){
			alertify.error('Debe seleccionar algún tipo de informe');
			return false;
		}
		/*if(!hay_taller){
			alertify.error('Debe seleccionar un taller');
			return false;
		}*/
		if(!hay_meses){
			alertify.error('Debe seleccionar al menos un mes');
			return false;
		}
	});
	// SECCIÓN DE LISTADOS

	$( ".mostrarocultar" ).click(function() {
		id=this.id;
		ids=id.split('_');
		iddiv=ids[1];
		$('.div_mostrarocultar').each(function(){
			if($(this).is(":visible")&&this.id!=iddiv){
				$(this).slideUp("slow");
			}
			else if(!$(this).is(":visible")&&(this.id=='contempleados'||this.id=='contequipos')){
				$(this).slideDown("slow");
			}
		});
		$("#"+iddiv).slideToggle("slow");
		cambiapos(iddiv);
	});

	$( ".banda" ).click(function() {
		id=this.id;
		ids=id.split('_');
		iddiv=ids[1];
		$('.div_icon').each(function(){
			if($(this).is(":visible")&&this.id!=iddiv){
				$(this).slideUp("slow");
				$('#icon_'+this.id).removeClass("active");
				$('#banda_'+this.id).removeClass("active");
			}
		});
		$("#"+iddiv).slideToggle("slow");
		$('#icon_'+iddiv).toggleClass("active");
		$('#banda_'+iddiv).toggleClass("active");
	});


	$('.colder .scroll').perfectScrollbar({
		wheelSpeed: 1,
		maxScrollbarLength: 40,
		wheelPropagation: false
	});

    // Menú hamburguesa
    var toggle = document.getElementById('menuToggle');
    var menu = document.querySelector('.menu-izq');
    var backdrop = document.getElementById('menuBackdrop');
    var menuIcon = document.getElementById('menuIcon');

    if(toggle && menu){
        function setBodyScroll(disable){
            document.body.style.overflow = disable ? 'hidden' : '';
        }

        function toggleMenu(){
            var isOpen = menu.classList.toggle('open');
            backdrop.classList.toggle('visible', isOpen);
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            setBodyScroll(isOpen);

            if(menuIcon){
                if(isOpen){
                    menuIcon.classList.remove('fa-bars');
                    menuIcon.classList.add('fa-xmark');
                } else {
                    menuIcon.classList.remove('fa-xmark');
                    menuIcon.classList.add('fa-bars');
                }
            }
        }

        toggle.addEventListener('click', toggleMenu);
        if(backdrop) backdrop.addEventListener('click', toggleMenu);
        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape' && menu.classList.contains('open')) toggleMenu();
        });
    }
});

function actualiza_busqueda_pormes(){
	meses='';
	$('.pormes').each(function(){
		$(this).prop('checked')?meses=meses+(meses==''?$(this).val():','+$(this).val()):'';
	});
	anho=$('#f_anho').val();

	//alert (meses);return false;

	contenido='ajax_filtro_pormes';
	$.ajax({
		type: "POST",
		url: "base_ajax/",
		data: {contenido:contenido, meses:meses, anho:anho},
		success: function (data) {
			$('#f_fecha_nombre').empty();
			$('#f_fecha_nombre').html(data);
			//console.log(data);
		},
		error: function (data) {
			//alert('error '+data);
			console.log(data);
		}
	});
	//console.log(provincias);
}

function actualiza_busqueda_provincia(){
	provincias='';
	if($("#f_prov_todas").prop('checked')){
		provincias='ALL';
	}
	else{
		$('.porprov').each(function(){
			$(this).prop('checked')?provincias=provincias+(provincias==''?'"'+$(this).val()+'"':',"'+$(this).val()+'"'):'';
		});
	}

	contenido='ajax_filtro_provincia';
	$.ajax({
		type: "POST",
		url: "base_ajax/",
		data: {contenido:contenido, provincias:provincias},
		success: function (data) {
			$('#f_prov_nombre').empty();
			$('#f_prov_nombre').html(data);
			//console.log(data);
		},
		error: function (data) {
			//alert('error '+data);
			console.log(data);
		}
	});
	//console.log(provincias);
}

function actualiza_busqueda_taller(valor){
	$('#f_taller_nombre').empty();
	$('#f_taller_nombre').html(valor==''?'':'<strong>Seleccionado:</strong> '+valor);
	tipo=$("#f_tipo_taller").val();
	if(tipo==1){//Taller independiente
		$("#f_prov_todas").prop('checked', true);
		$("#f_prov_todas").prop('disabled', true);
		$('.porprov').each(function(){
			$(this).prop('checked',true);
			$(this).prop('disabled',true);
		});
		actualiza_busqueda_provincia();
	}
	else{//Red de talleres
		$("#f_prov_todas").prop('disabled', false);
		$('.porprov').each(function(){
			$(this).prop('disabled',false);
		});
	}
}
function nuevapass(){
	correo=$('#astc_email').val();
	if(correo==''){
		alertify.error('Por favor, indique su correo electrónico o alias de acceso');
		return false;
	}
	else{
		$('#np_correo').val(correo);
		return true;
	}
}

function muestra_datosemp(idcampo){
	idempleado=$('#'+idcampo).val();
	if($('#'+idcampo).prop('checked')){
		$("#empleado_"+idempleado).show();
	}
	else{
		$("#empleado_"+idempleado).hide();
	}
}

function cambiapos(id){
	$('.mostrarocultar').each(function(){
		if(this.id!='mostrarocultar_'+id){
			$(this).css('backgroundPosition', '50% 0%');
		}
	});
	myPos = $('#mostrarocultar_'+id).css("background-position").split(" ");
	if(myPos[1]=='0%'){
		$('#mostrarocultar_'+id).css('backgroundPosition', '50% 100%');
	}
	else{
		$('#mostrarocultar_'+id).css('backgroundPosition', '50% 0%');
	}
}

$(function() {
	$( ".check_ui" ).button();
	$( document ).tooltip({
	  content: function(callback) {
		 callback(
		 	$(this).prop('title').replace(/<br>/g, '<br />').replace(/<strong>/g, '<strong>').replace(/<\/strong>/g, '</strong>')
		 );
	  }
	});
});

function mueveReloj(){
	momentoActual = new Date()
	hora = momentoActual.getHours()
	minuto = momentoActual.getMinutes()
	minuto=("0" + minuto).slice (-2);
	segundo = momentoActual.getSeconds()
	segundo=("0" + segundo).slice (-2);

	horaImprimible = hora+":"+minuto+":"+segundo;

	document.getElementById("imp_hora").innerHTML=""+horaImprimible+"";

	setTimeout("mueveReloj()",1000);
}

function comprueba_cambios(idform){
	haycambios=0;
	$('#'+idform+' .orig').each(function(){
		id=this.id;
		if($(this).attr('type')=='checkbox'){
			valor=$(this).prop('checked')?$(this).val():0;
		}
		else{
			valor=$(this).val();
		}
		valor!=$('#'+id+'_def').val()?haycambios=1:'';
		//alert(id+' - '+valor+' - '+$('#'+id+'_def').val());
	});
	haycambios==0?$('#'+idform+' input[type="submit"]').hide():$('#'+idform+' input[type="submit"]').show();
}

function comprueba_cambios_empleado(idempleado){
	haycambios=0;
	$('#nombre_'+idempleado).val()!=$('#nombre_'+idempleado+'_def').val()?haycambios=1:'';
	$('#jornada_'+idempleado).val()!=$('#jornada_'+idempleado+'_def').val()?haycambios=1:'';
	$('#notas_'+idempleado).val()!=$('#notas_'+idempleado+'_def').val()?haycambios=1:'';
	for(n=1; n<=4; n++){
		funcion=$('#funcion_'+n+'_'+idempleado+'').val()==null?'':$('#funcion_'+n+'_'+idempleado+'').val();
		funciondef=$('#funcion_'+n+'_'+idempleado+'_def').val()==''?'':$('#funcion_'+n+'_'+idempleado+'_def').val();
		porcent=$('#porcent_'+n+'_'+idempleado+'').val()==null?'':$('#porcent_'+n+'_'+idempleado+'').val();
		porcentdef=$('#porcent_'+n+'_'+idempleado+'_def').val()==''?'':$('#porcent_'+n+'_'+idempleado+'_def').val();
		funcion!=funciondef?haycambios=1:'';
		porcent!=porcentdef?haycambios=1:'';
	}
	haycambios==0?$('#guardaempleado_'+idempleado).hide():$('#guardaempleado_'+idempleado).show();
}

function comprueba_cambios_equipo(idequipo){
	haycambios=0;
	$('#cantidad_'+idequipo).val()!=$('#cantidad_'+idequipo+'_def').val()?haycambios=1:'';
	$('#notas_'+idequipo).val()!=$('#notas_'+idequipo+'_def').val()?haycambios=1:'';
	tipo=$('#tipo_'+idequipo+'').val()==null?'':$('#tipo_'+idequipo+'').val();
	tipodef=$('#tipo_'+idequipo+'_def').val();
	tipo!=tipodef?haycambios=1:'';
	haycambios==0?$('#guardaequipo_'+idequipo).hide():$('#guardaequipo_'+idequipo).show();
}

function eliminar(tipo, iditem){
	if(tipo=='empleado'){
		alertify.confirm('Se necesita confirmación', '¿Seguro que desea modificar el elemento seleccionado?', function(i){
			if(i){
				borra_item(tipo, iditem);
			}
		}, null);
	}
	else{
		alertify.confirm('Se necesita confirmación', '¿Seguro que desea eliminar definitivamente el elemento seleccionado?', function(i){
			if(i){
				borra_item(tipo, iditem);
			}
		}, null);
	}
}

function act_onoff(iditem){
	posicion=$('#onoff_'+iditem).css('backgroundPosition').split(' ');
	if(posicion[1]=='0%'){
		$('#onoff_'+iditem).css('backgroundPosition', '50% 100%');
		$('#onoff_'+iditem).prop('title', 'Activar');
	}
	else{
		$('#onoff_'+iditem).css('backgroundPosition', '50% 0%');
		$('#onoff_'+iditem).prop('title', 'Desactivar');
	}
}

function borra_item(tipo, iditem){
	contenido='elimina_item';
	$.ajax({
		type: "POST",
		url: "base_ajax/",
		data: {contenido:contenido, tipo:tipo, iditem:iditem},
		success: function(data) {
			if(data=='true'){
				if(tipo=='empleado'){
					alertify.success('Modificado correctamente');
					act_onoff(iditem);
                    dame_empleados();
				}
				else{
					alertify.success('Eliminado correctamente');
					$('#it_'+tipo+'_'+iditem).slideUp(500);
					$('#it_'+tipo+'_'+iditem).fadeOut(500);
					setTimeout(function(){
						$('#it_'+tipo+'_'+iditem).remove();
					}, 500);
				}
			}
			else{
				alertify.error(data);
				console.log(data);
			}
		}
	});
}

function dame_empleados(){
    contenido='dame_empleados';
    $.ajax({
        type: "POST",
        url: "base_ajax/",
        data: {contenido:contenido},
        success: function(data) {
            $('#empleados_total').html($('#res_empleados_total' , data).html());
            $('#empleados_directos').html($('#res_empleados_directos' , data).html());
            $('#empleados_dir_porc').html($('#res_empleados_dir_porc' , data).html());
            $('#empleados_indirectos').html($('#res_empleados_indirectos' , data).html());
            $('#empleados_indir_porc').html($('#res_empleados_indir_porc' , data).html());
        }
    });
}

function comprueba_sino(valor, campo){
	contenido='sino_'+campo;
	$.ajax({
		type: "POST",
		url: "base_ajax/",
		data: {contenido:contenido, valor:valor},
		success: function(data) {
			$('#'+campo+'_val').val($('#valor' , data).html());
			$('#'+campo+'_sino').html($('#imagen' , data).html());
		}
	});
}

function activa_actividad(idactiv){
	if($('#activ_'+idactiv).prop('checked')){
		$('#metros_'+idactiv).prop('disabled', false);
		$('#metros_'+idactiv).val($('#metros_'+idactiv+'_def').val());
		$('#puestos_'+idactiv).prop('disabled', false);
		$('#puestos_'+idactiv).val($('#puestos_'+idactiv+'_def').val());
		$('#elevadores_'+idactiv).prop('disabled', false);
		$('#elevadores_'+idactiv).val($('#elevadores_'+idactiv+'_def').val());
	}
	else{
		$('#metros_'+idactiv).val(0.00);
		$('#metros_'+idactiv).prop('disabled', true);
		$('#puestos_'+idactiv).val(0);
		$('#puestos_'+idactiv).prop('disabled', true);
		$('#elevadores_'+idactiv).val(0);
		$('#elevadores_'+idactiv).prop('disabled', true);
	}
	comprueba_cambios('edita_actividad')
}

function comprueba_num(idcampo){
	valor=$('#'+idcampo).val();
	if(isNaN(valor)){
		$('#'+idcampo).val(0);
	}
}

function sumalinea_datosact(decimales, idcampo, datos){
	lista_datos=datos.split(',');
	dato1=$('#'+idcampo+lista_datos[0]).val()==''?0:$('#'+idcampo+lista_datos[0]).val();
	dato2=$('#'+idcampo+lista_datos[1]).val()==''?0:$('#'+idcampo+lista_datos[1]).val();
	dato3=$('#'+idcampo+lista_datos[2]).val()==''?0:$('#'+idcampo+lista_datos[2]).val();
	if(isNaN(dato1)||isNaN(dato2)||isNaN(dato3)){
		return false;
	}
	else{
		$('#'+idcampo+'total').val((parseFloat(dato1)+parseFloat(dato2)+parseFloat(dato3)).toFixed(decimales));
		comprueba_cambios('edita_datosactividad')
	}
}

function sumacol_datosact(idcampo, iddato){
	if(idcampo=='facturado_'){
		dato1=parseFloat($('#facturadomo_'+iddato).val())==''?0:parseFloat($('#facturadomo_'+iddato).val());
		dato2=parseFloat($('#facturadorec_'+iddato).val())==''?0:parseFloat($('#facturadorec_'+iddato).val());
		dato3=parseFloat($('#facturadootros_'+iddato).val())==''?0:parseFloat($('#facturadootros_'+iddato).val());
		if(isNaN(dato1)||isNaN(dato2)||isNaN(dato3)){
			return false;
		}
		else{
			$('#facturado_'+iddato).val((dato1+dato2+dato3).toFixed(2));
		}
	}
	/*
	else if(idcampo=='cobrado_'){
		dato1=parseFloat($('#cobradomo_'+iddato).val())==''?0:parseFloat($('#cobradomo_'+iddato).val());
		dato2=parseFloat($('#cobradorec_'+iddato).val())==''?0:parseFloat($('#cobradorec_'+iddato).val());
		dato3=parseFloat($('#cobradootros_'+iddato).val())==''?0:parseFloat($('#cobradootros_'+iddato).val());
		if(isNaN(dato1)||isNaN(dato2)||isNaN(dato3)){
			return false;
		}
		else{
			$('#cobrado_'+iddato).val((dato1+dato2+dato3).toFixed(2));
		}
	}
	*/
	else{
		return false;
	}
}

function sumacol_datosactmes(idcampo, iddato){
	if(idcampo=='facturado_'){
		dato1=parseFloat($('#facturadomo_'+iddato).val())==''?0:parseFloat($('#facturadomo_'+iddato).val());
		dato2=parseFloat($('#facturadorec_'+iddato).val())==''?0:parseFloat($('#facturadorec_'+iddato).val());
		dato3=parseFloat($('#facturadootros_'+iddato).val())==''?0:parseFloat($('#facturadootros_'+iddato).val());
		if(isNaN(dato1)||isNaN(dato2)||isNaN(dato3)){
			return false;
		}
		else{
			$('#facturado_'+iddato).val((parseFloat(dato1)+parseFloat(dato2)+parseFloat(dato3)).toFixed(2));
		}
	}
	/*
	else if(idcampo=='cobrado_'){
		dato1=parseFloat($('#cobradomo_'+iddato).val())==''?0:parseFloat($('#cobradomo_'+iddato).val());
		dato2=parseFloat($('#cobradorec_'+iddato).val())==''?0:parseFloat($('#cobradorec_'+iddato).val());
		dato3=parseFloat($('#cobradootros_'+iddato).val())==''?0:parseFloat($('#cobradootros_'+iddato).val());
		if(isNaN(dato1)||isNaN(dato2)||isNaN(dato3)){
			return false;
		}
		else{
			$('#cobrado_'+iddato).val((dato1+dato2+dato3).toFixed(2));
		}
	}
	*/
	else{
		return false;
	}
}

function datos_presencia(idsdatos){
	lista_datos=idsdatos.split(',');
	$.each(lista_datos, function(key, value){
		improductivas=0.00;//horas perdidas
		hprod=0;//Horas productivas o presencia
		/*
		$('.pres_emp').each(function(){
			if($(this).prop('checked')){
				idempleado=$(this).val();
				jornada=$('#jornada_'+idempleado).val();
				diaslab=$('#diaslab_'+value).val();
				extraspagadas=$('#extraspagadas_'+idempleado+'_'+value).val();
				diasvacaciones=$('#diasvacaciones_'+idempleado+'_'+value).val();
				diasbaja=$('#diasbaja_'+idempleado+'_'+value).val();
				diaspermiso=$('#diaspermiso_'+idempleado+'_'+value).val();
				diasformacion=$('#diasformacion_'+idempleado+'_'+value).val();
				notrabajados=parseFloat(diasvacaciones)+parseFloat(diasbaja)+parseFloat(diaspermiso)+parseFloat(diasformacion);
				improductivas=parseFloat(improductivas)+parseFloat((jornada*(notrabajados-extraspagadas)));
				//alert(jornada+' - '+improductivas);
			}
		})
		*/
		facturado=parseFloat($('#facturadomo_'+value).val());
		importemo=parseFloat($('#importemo_'+value).val());
		hcobradas=(facturado/importemo).toFixed(2);
		diaslab=parseFloat($('#diaslab_'+value).val());
		if($('#presenciaxemp').prop('checked')){
			$('.pres_emp').each(function(){
				if($(this).prop('checked')){
					idempleado=$(this).val();
					jornada=$('#jornada_'+idempleado).val();
					hprod+=parseFloat(jornada*diaslab);
				}
			})
			$('#horaspresencia_'+value).val(hprod.toFixed(2));
		}
		else{
			hprod=parseFloat($('#horaspresencia_'+value).val());
		}

		if(hprod>0&&hprod>hcobradas){
			hperdidas=(hprod-hcobradas).toFixed(2);
			nofacturado=(hperdidas*importemo).toFixed(2);
		}
		else{
			hperdidas=0.00;
			nofacturado=0.00;
		}
		//alert (hperdidas);
		//$('#horaspresencia_'+value).val(hprod>0?hprod.toFixed(2):0.00);
		$('#horasfac_'+value).val(hcobradas);
		$('#horasimproductivas_'+value).val(hperdidas);
		$('#nofacturado_'+value).val(nofacturado);
	})

}

function muestra_empleados(iddato){
	if($('#presenciaxemp').prop('checked')){
		$('#empleados').show();
		$('#horaspresencia_'+iddato).prop('readonly', true);
		$('#horaspresencia_'+iddato).css('background-color', '#ffd7b4');
		datos_presencia(iddato);
	}
	else{
		$('#empleados').hide();
		$('#horaspresencia_'+iddato).prop('readonly', false);
		$('#horaspresencia_'+iddato).css('background-color', 'transparent');
	}
}

function comprueba_pass(idempleado){
	//re = /^[0-9-A-z\u00F1\u00D1_@$&]*$/;
	if($('#accpass_'+idempleado).val()!=''&&($('#accpass2_'+idempleado).val()==''||$('#accpass3_'+idempleado).val()=='')){
		alertify.error('Si desea modificar la contraseña debe cumplimentar todos los datos');
		return false;
	}
	else if($('#accpass_'+idempleado).val()!=$('#accpass2_'+idempleado).val()){
		alertify.error('Las contraseñas no coinciden; debe repetir la nueva contraseña');
		return false;
	}
	else if (!pass_pat.test($('#accpass_'+idempleado).val())){
		alertify.error('La contraseña sólo puede contener letras, números, guiones y los caracteres @, $, &amp;');
		$('#accpass_'+idempleado).focus();
		return false;
	}
	else if ($('#accpass_'+idempleado).val().length>0&&$('#accpass_'+idempleado).val().length<6){
		alertify.error('La contraseña debe tener al menos 6 caracteres');
		$('#accpass_'+idempleado).focus();
		return false;
	}
	else{
		return true;
	}
}

function cambia_pass(idempleado){
	if($('#accpass_'+idempleado).val()!=''){
		$('#rep_pass').show()
	}
	else{
		$('#accpass2_'+idempleado).val('');
		$('#accpass3_'+idempleado).val('');
		$('#rep_pass').hide();
		$('#ant_pass').hide();
	}
	if($('#accpass2_'+idempleado).val()!=''&&$('#accpass_'+idempleado).val()==$('#accpass2_'+idempleado).val()){
		$('#ant_pass').show()
	}
	else{
		$('#accpass3_'+idempleado).val('');
		$('#ant_pass').hide();
	}
}

function validateCIF(cif){
	//Quitamos el primer caracter y el ultimo digito
	var valueCif=cif.substr(1,cif.length-2);

	var suma=0;

	//Sumamos las cifras pares de la cadena
	for(i=1;i<valueCif.length;i=i+2){
		suma=suma+parseInt(valueCif.substr(i,1));
	}

	var suma2=0;

	//Sumamos las cifras impares de la cadena
	for(i=0;i<valueCif.length;i=i+2){
		result=parseInt(valueCif.substr(i,1))*2;
		if(String(result).length==1){
			// Un solo caracter
			suma2=suma2+parseInt(result);
		}
		else{
			// Dos caracteres. Los sumamos...
			suma2=suma2+parseInt(String(result).substr(0,1))+parseInt(String(result).substr(1,1));
		}
	}

	// Sumamos las dos sumas que hemos realizado
	suma=suma+suma2;

	var unidad=String(suma).substr(1,1)
	unidad=10-parseInt(unidad);

	var primerCaracter=cif.substr(0,1).toUpperCase();

	if(primerCaracter.match(/^[FJKNPQRSUVW]$/)){
		//Empieza por .... Comparamos la ultima letra
		if(String.fromCharCode(64+unidad).toUpperCase()==cif.substr(cif.length-1,1).toUpperCase())
			return true;
	}
	else if(primerCaracter.match(/^[XYZ]$/)){
		//Se valida como un dni
		var newcif;
		if(primerCaracter=="X")
			newcif=cif.substr(1);
		else if(primerCaracter=="Y")
			newcif="1"+cif.substr(1);
		else if(primerCaracter=="Z")
			newcif="2"+cif.substr(1);
		return validateDNI(newcif);
	}
	else if(primerCaracter.match(/^[ABCDEFGHLM]$/)){
		//Se revisa que el ultimo valor coincida con el calculo
		if(unidad==10)
			unidad=0;
		if(cif.substr(cif.length-1,1)==String(unidad))
			return true;
	}
	else{
		//Se valida como un dni
		return validateDNI(cif);
	}
	return false;
}

function validateDNI(dni){
	var lockup = 'TRWAGMYFPDXBNJZSQVHLCKE';
	var valueDni=dni.substr(0,dni.length-1);
	var letra=dni.substr(dni.length-1,1).toUpperCase();

	if(lockup.charAt(valueDni % 23)==letra)
		return true;
	return false;
}

function cambianif(dato) {
	valor=$("#"+dato).val();
	valor =  valor.replace(/[^a-zA-Z0-9]+/g,'');
	valor=valor.toUpperCase()
	$("#"+dato).val(valor);
}

function limpiatlf(dato) {
	valor=$("#"+dato).val();
	valor =  valor.replace(/[^0-9+]+/g,'');
	$("#"+dato).val(valor);
}

function cambiarango(valor){
	if(valor==2){//Administrador
		$('#taller_NEW option[value="0"]').prop("selected", true);
		$('#taller_NEW').prop("disabled", true);
		$('#red_NEW').prop("disabled", false);
		$('#parared').show();
		$('#parataller').hide();
	}
	else if(valor==3){//Estandar
		$('#red_NEW option[value="0"]').prop("selected", true);
		$('#red_NEW').prop("disabled", true);
		$('#taller_NEW').prop("disabled", false);
		$('#parataller').show();
		$('#parared').hide();
	}
	else{
		return false;
	}
}

function cambiatipo(valor){
	if(valor==1){//Taller
		$('#red_NEW option[value="0"]').prop("selected", true);
		$('#red_NEW').prop("disabled", false);
		$('#parared').show();
		$('#pago_NEW option[value="5"]').prop("disabled", false);//habilitamos abonado
	}
	else if(valor==2){//Red
		$('#red_NEW option[value="0"]').prop("selected", true);
		$('#red_NEW').prop("disabled", true);
		$('#parared').hide();
		$('#pago_NEW option[value="2"]').prop("selected", true);//marcamos trimestral
		$('#pago_NEW option[value="5"]').prop("disabled", true);//deshabilitamos abonado
	}
	else{
		return false;
	}
}

function tipo_promo(tipo){
	if(tipo==1){//Suscripción
		$('#estipo_1').show();
		$('#adj_archivo').hide();
	}
	else if(tipo==2){//Obsequio
		$('#estipo_1').hide();
		$('#adj_archivo').hide();
	}
	else if(tipo==3){//Libre
		$('#estipo_1').hide();
		$('#adj_archivo').show();
	}
	else{
		return false;
	}
}

function cambiared(valor){
	if(valor==0){//Taller independiente
		$('#contrato_NEW').prop("disabled", false);
		$('#esmodulo').show();
	}
	else {//Pertenece a red
		$('#contrato_NEW').prop("disabled", true);
		$('#esmodulo').hide();
	}
}

function valida_editataller(idtaller){
	$('#mostrarocultar_datoscontrato').show();
	$('#mostrarocultar_datostaller').show();
	$('#mostrarocultar_datosfacturacion').show();
}

function valida_nuevotaller(idtaller){
	razsoc=$('#razsoc_'+idtaller).val();
	cif=$('#cif_'+idtaller).val();
	telefono=$('#telefono_'+idtaller).val();
	correo=$('#correo_'+idtaller).val();
	dirr=$('#dirr_'+idtaller).val();
	cp=$('#cp_'+idtaller).val();
	loc=$('#loc_'+idtaller).val();
	prov=$('#prov_'+idtaller).val();

	if(razsoc==''){
		alertify.error('Debe indicar la razón social');
		return false;
	}
	if(cif==''){
		alertify.error('Debe indicar el CIF/NIF');
		return false;
	}
	if(telefono==''){
		alertify.error('Debe indicar el teléfono de contacto');
		return false;
	}
	if(correo==''){
		alertify.error('Debe indicar el correo electrónico');
		return false;
	}
	if (!mail_pat.test(correo)){
		alertify.error('El correo electrónico no es correcto');
		return false;
	}
	if(dirr==''){
		alertify.error('Debe indicar la dirección');
		return false;
	}
	if(cp==''){
		alertify.error('Debe indicar el código postal');
		return false;
	}
	if(loc==''){
		alertify.error('Debe indicar la localidad');
		return false;
	}
	if(prov==''){
		alertify.error('Debe indicar la provincia');
		return false;
	}
}


function cambia_taller(idtaller){
	contenido='cambia_taller';
	$.ajax({
		type: "POST",
		url: "base_ajax/",
		data: {contenido:contenido, idtaller:idtaller},
		success: function(data) {
			location.reload();
		}
	});
}

function act_fac(idlinea){
	valoriva=parseFloat($('#tipoiva').val());
	cantidad=parseInt($('#cant'+idlinea).val());
	preciou=parseFloat($('#preu'+idlinea).val());
	dto=parseFloat($('#dto'+idlinea).val());

	if(cantidad==''){
		cantidad=0;
	}
	$('#cant'+idlinea).val(cantidad);
	if(preciou==''){
		preciou=0.00;
	}
	$('#preu'+idlinea).val(preciou.toFixed(2));
	if(dto==''){
		dto=0.00;
	}
	$('#dto'+idlinea).val(dto.toFixed(2));

	if($.isNumeric(cantidad)==false||cantidad%1!=0){
		alertify.error('La cantidad debe ser un número entero (sin decimales)');
		$('#cant'+idlinea).val(0);
		$('#cant'+idlinea).focus();
		return false;
	}
	if($.isNumeric(preciou)==false){
		alertify.error('El precio indicado no es válido');
		$('#preu'+idlinea).focus();
		return false;
	}
	if($.isNumeric(dto)==false){
		alertify.error('El descuento indicado no es válido');
		$('#dto'+idlinea).focus();
		return false;
	}

	if(dto==0){
		impbase=cantidad*preciou;
	}
	else {
		impbase=cantidad*(preciou-(preciou*dto/100));
	}
	$('#imp'+idlinea).val(impbase.toFixed(2));
	act_totales();
}
function act_totales(){
	base=0.00;
	valoriva=parseFloat($('#tipoiva').val());
	retiene=$('#retiene').val();
	$('input[name="imp[]"]').each(function() {
		base+=parseFloat($(this).val());
	});
	base=base.toFixed(2);
	iva=(base*(valoriva/100)).toFixed(2);
	rec=retiene==0?0.00:(base*(5.20/100)).toFixed(2);
	total=(parseFloat(base)+parseFloat(iva)+parseFloat(rec)).toFixed(2);
	$('#base').val(base);
	$('#iva').val(iva);
	$('#recargo').val(rec);
	$('#total').val(total);
}

function cambia_estado(estado, idfactura){
	contenido='cambia_estado';
	$.ajax({
		type: "POST",
		url: "base_ajax/",
		data: {contenido:contenido, estado:estado, idfactura:idfactura},
		success: function(data) {
			$('#estado_fac_'+idfactura).html(data);
			alertify.success('Modificado correctamente.');
		},
		error: function () {
			alertify.error('¡¡¡ERROR!!!<br>Actualice la página y vuelva a intentarlo.');
		}
	});
}

function comprueba_promocion(idpromo){

	tipo=$('#tipo_'+idpromo).val();
	archivo=$('#imagen_'+idpromo).val().split('.');
	l_ar=archivo.length;
	extension=archivo[l_ar-1].toLowerCase();
	//alert(extension);
	//return false;
	if(tipo==1&&$('#meses_'+idpromo).val()<1){
		alertify.error('Debe indicar una duración en meses para la suscripción gratis');
		$('#meses_'+idpromo).focus()
		return false;
	}
	if($('#desde_'+idpromo).val()==''){
		alertify.error('Debe indicar la fecha de inicio de la promoción');
		$('#desde_'+idpromo).focus()
		return false;
	}
	if($('#hasta_'+idpromo).val()==''){
		alertify.error('Debe indicar la fecha de fin de la promoción');
		$('#hasta_'+idpromo).focus()
		return false;
	}
	if($('#desde_'+idpromo).val()>$('#hasta_'+idpromo).val()){
		alertify.error('La fecha de fin debe ser posterior a la fecha de inicio.');
		$('#hasta_'+idpromo).focus()
		return false;
	}
	if($('#titulo_'+idpromo).val()==''){
		alertify.error('Debe indicar un título para la promoción');
		$('#titulo_'+idpromo).focus()
		return false;
	}
	ext_error=1;
	$.each(ext_img, function(index, value){
		if(value==extension){
			ext_error=0;
		}
	});
	if(extension!=''&&ext_error==1){
		alertify.error('La extensión del archivo no es válida');
		$('#imagen_'+idpromo).focus()
		return false;
	}
}

function cambia_est_promo(idtaller, durpromo){
	contenido='cambia_estado_promocion';
	$.ajax({
		type: "POST",
		url: "base_ajax/",
		data: {contenido:contenido, idtaller:idtaller, durpromo:durpromo},
		success: function(data) {
			$('#estpromo_'+idtaller).empty(data);
			$('#estpromo_'+idtaller).html(data);
			alertify.success('Modificado correctamente.');
		},
		error: function () {
			alertify.error('¡¡¡ERROR!!!<br>Actualice la página y vuelva a intentarlo.');
			console.log(data);
		}
	});
}

function carga_datos(valor){
	if(valor==='99'){
		$("#tall_mes").hide();
		$("#tall_anho").hide();
	}
	else{
		$("#tall_mes").show();
		$("#tall_anho").show();
	}
}

function drawChart_columnas_upd(contenido, dato, titulo, contenedor){
    // Requiere Chart.js cargado en la página
    $.ajax({
        type: "POST",
        url: "base_ajax/",
        data: {contenido: contenido, dato: dato},
        dataType: "json"
    }).done(function(jsonData) {
        try {
            // Comprobaciones básicas del formato DataTable (cols / rows)
            if(!jsonData || !Array.isArray(jsonData.cols) || !Array.isArray(jsonData.rows) || jsonData.cols.length < 2){
                throw new Error('Formato de datos no válido');
            }

            // Convertir DataTable a etiquetas y datasets
            var labels = jsonData.rows.map(function(r){ return r.c && r.c[0] ? r.c[0].v : null; });
            var datasets = [];
            var palette = [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(201, 203, 207, 0.8)'
            ];

            for(var col = 1; col < jsonData.cols.length; col++){
                (function(colIndex){
                    var data = jsonData.rows.map(function(r){
                        var cell = r.c && r.c[colIndex] ? r.c[colIndex].v : 0;
                        return (cell === null || cell === undefined) ? 0 : cell;
                    });
                    var color = palette[(colIndex-1) % palette.length];
                    datasets.push({
                        label: jsonData.cols[colIndex].label || ('Serie ' + colIndex),
                        data: data,
                        backgroundColor: color,
                        borderColor: color.replace(/0\.8\)$/, '1)'),
                        borderWidth: 1
                    });
                })(col);
            }

            var containerEl = document.getElementById(contenedor);
            if(!containerEl){
                console.error('Contenedor no encontrado:', contenedor);
                return;
            }

            // Si el contenedor no es canvas, crear/reemplazar por uno para Chart.js
            var canvas;
            if(containerEl.tagName.toLowerCase() === 'canvas'){
                canvas = containerEl;
            } else {
                // conservar contenido para fallback
                containerEl.innerHTML = '';
                canvas = document.createElement('canvas');
                canvas.style.width = '100%';
                containerEl.appendChild(canvas);
            }

            // Reutilizar instancia de chart si existe
            if(canvas._chartInstance){
                canvas._chartInstance.data.labels = labels;
                canvas._chartInstance.data.datasets = datasets;
                canvas._chartInstance.options.plugins.title.text = titulo || '';
                canvas._chartInstance.update();
            } else {
                // Crear nueva instancia Chart.js (compatible con Chart.js v3+)
                var ctx = canvas.getContext('2d');
                canvas._chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: !!titulo,
                                text: titulo || ''
                            },
                            legend: {
                                display: false // igual que el original: sin leyenda
                            }
                        },
                        scales: {
                            x: {
                                stacked: false
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        } catch(e) {
            // Mostrar mensaje amigable en el contenedor
            $("#"+contenedor).html('<div style="text-align:center; padding:60px">No hay datos o formato no válido</div>');
            console.error(e);
        }
    }).fail(function() {
        $("#"+contenedor).html('<div style="text-align:center; padding:60px">No hay datos</div>');
    });
}
function drawChart_columnas_legend_upd(contenido, dato, titulo, contenedor){
    // Requiere Chart.js cargado en la página
    $.ajax({
        type: "POST",
        url: "base_ajax/",
        data: {contenido: contenido, dato: dato},
        dataType: "json"
    }).done(function(jsonData) {
        try {
            if(!jsonData || !Array.isArray(jsonData.cols) || !Array.isArray(jsonData.rows) || jsonData.cols.length < 2){
                throw new Error('Formato de datos no válido');
            }

            var labels = jsonData.rows.map(function(r){ return r.c && r.c[0] ? r.c[0].v : null; });
            var datasets = [];
            var palette = [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(201, 203, 207, 0.8)'
            ];

            for(var col = 1; col < jsonData.cols.length; col++){
                (function(colIndex){
                    var data = jsonData.rows.map(function(r){
                        var cell = r.c && r.c[colIndex] ? r.c[colIndex].v : 0;
                        return (cell === null || cell === undefined) ? 0 : cell;
                    });
                    var color = palette[(colIndex-1) % palette.length];
                    datasets.push({
                        label: jsonData.cols[colIndex].label || ('Serie ' + colIndex),
                        data: data,
                        backgroundColor: color,
                        borderColor: color.replace(/0\.8\)$/, '1)'),
                        borderWidth: 1
                    });
                })(col);
            }

            var containerEl = document.getElementById(contenedor);
            if(!containerEl){
                console.error('Contenedor no encontrado:', contenedor);
                return;
            }

            var canvas;
            if(containerEl.tagName.toLowerCase() === 'canvas'){
                canvas = containerEl;
            } else {
                containerEl.innerHTML = '';
                canvas = document.createElement('canvas');
                canvas.style.width = '100%';
                // asegurar un contenedor con altura para que Chart.js responsivo funcione
                if(!containerEl.style.minHeight) containerEl.style.minHeight = '240px';
                containerEl.appendChild(canvas);
            }

            if(canvas._chartInstance){
                canvas._chartInstance.data.labels = labels;
                canvas._chartInstance.data.datasets = datasets;
                // actualizar título y leyenda
                if(!canvas._chartInstance.options.plugins) canvas._chartInstance.options.plugins = {};
                canvas._chartInstance.options.plugins.title = canvas._chartInstance.options.plugins.title || {};
                canvas._chartInstance.options.plugins.title.display = !!titulo;
                canvas._chartInstance.options.plugins.title.text = titulo || '';
                canvas._chartInstance.options.plugins.legend = canvas._chartInstance.options.plugins.legend || {};
                canvas._chartInstance.options.plugins.legend.display = true;
                canvas._chartInstance.options.plugins.legend.position = 'bottom';
                canvas._chartInstance.update();
            } else {
                var ctx = canvas.getContext('2d');
                canvas._chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: !!titulo,
                                text: titulo || ''
                            },
                            legend: {
                                display: true,
                                position: 'bottom'
                            }
                        },
                        scales: {
                            x: { stacked: false },
                            y: { beginAtZero: true }
                        }
                    }
                });
            }
        } catch(e) {
            $("#"+contenedor).html('<div style="text-align:center; padding:60px">No hay datos o formato no válido</div>');
            console.error(e);
        }
    }).fail(function() {
        $("#"+contenedor).html('<div style="text-align:center; padding:60px">No hay datos</div>');
    });
}
function drawChart_linear_upd(contenido, dato, titulo, contenedor){
    // Requiere Chart.js cargado en la página
    $.ajax({
        type: "POST",
        url: "base_ajax/",
        data: {contenido: contenido, dato: dato},
        dataType: "json"
    }).done(function(jsonData) {
        try {
            if(!jsonData || !Array.isArray(jsonData.cols) || !Array.isArray(jsonData.rows) || jsonData.cols.length < 2){
                throw new Error('Formato de datos no válido');
            }

            // Labels desde la primera columna
            var labels = jsonData.rows.map(function(r){ return r.c && r.c[0] ? r.c[0].v : null; });

            // Construir datasets desde la segunda columna en adelante
            var datasets = [];
            var palette = [
                'rgba(54, 162, 235, 0.9)',
                'rgba(255, 99, 132, 0.9)',
                'rgba(255, 205, 86, 0.9)',
                'rgba(75, 192, 192, 0.9)',
                'rgba(153, 102, 255, 0.9)',
                'rgba(201, 203, 207, 0.9)'
            ];

            for(var col = 1; col < jsonData.cols.length; col++){
                (function(colIndex){
                    var data = jsonData.rows.map(function(r){
                        var cell = r.c && r.c[colIndex] ? r.c[colIndex].v : 0;
                        var num = (cell === null || cell === undefined || cell === '') ? 0 : Number(cell);
                        return isNaN(num) ? 0 : num;
                    });
                    var color = palette[(colIndex-1) % palette.length];
                    datasets.push({
                        label: jsonData.cols[colIndex].label || ('Serie ' + colIndex),
                        data: data,
                        borderColor: color,
                        backgroundColor: color.replace(/0\.9\)$/, '0.4)'),
                        fill: false,
                        tension: 0.2,
                        pointRadius: 3,
                        borderWidth: 2
                    });
                })(col);
            }

            var containerEl = document.getElementById(contenedor);
            if(!containerEl){
                console.error('Contenedor no encontrado:', contenedor);
                return;
            }

            // Crear o reutilizar canvas
            var canvas;
            if(containerEl.tagName.toLowerCase() === 'canvas'){
                canvas = containerEl;
            } else {
                containerEl.innerHTML = '';
                canvas = document.createElement('canvas');
                canvas.style.width = '100%';
                if(!containerEl.style.minHeight) containerEl.style.minHeight = '240px';
                containerEl.appendChild(canvas);
            }

            // Reutilizar instancia si existe
            if(canvas._chartInstance){
                canvas._chartInstance.data.labels = labels;
                canvas._chartInstance.data.datasets = datasets;
                if(canvas._chartInstance.options && canvas._chartInstance.options.plugins && canvas._chartInstance.options.plugins.title){
                    canvas._chartInstance.options.plugins.title.display = !!titulo;
                    canvas._chartInstance.options.plugins.title.text = titulo || '';
                }
                canvas._chartInstance.update();
            } else {
                var ctx = canvas.getContext('2d');
                canvas._chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: !!titulo,
                                text: titulo || ''
                            },
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                display: true,
                                ticks: { autoSkip: true }
                            },
                            y: {
                                beginAtZero: true,
                                display: true
                            }
                        }
                    }
                });
            }
        } catch(e) {
            $("#"+contenedor).html('<div style="text-align:center; padding:60px">No hay datos o formato no válido</div>');
            console.error(e);
        }
    }).fail(function() {
        $("#"+contenedor).html('<div style="text-align:center; padding:60px">No hay datos</div>');
    });
}