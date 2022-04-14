<?php
function f_euro($celda){//formato EURO con 2 decimales y rojo si negativo
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet() ->getStyle($celda)->getNumberFormat()->setFormatCode('_-* 0.00 €_-;-* 0.00 €_-;_-* "-"?? €_-;_-@_-');
}

function no_dec($celda){//formato de número sin decimales
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet() ->getStyle($celda)->getNumberFormat()->setFormatCode('_-* 0_-;-* 0_-;_-* "-"??_-;_-@_-');
}

function get_cell($celda){
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getCell($celda)->getValue();
}

function f_percent($celda){//formato porcentaje con 2 decimales
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle($celda)->getNumberFormat()->setFormatCode("0.00%");
}

function color_text($celda,$color){//establece el color de texto de la celda
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle($celda)->applyFromArray(array('font'  => array('color' => array('rgb' => $color))));
}

function color_bg($celda,$color){//Establece el color de fondo de la celda
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle($celda)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => $color))));
}

function negrita($celda){//Texto de la celda en negrita
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle($celda)->getFont()->setBold(true);
}

function centrado($celda){//Centra el texto de la celda o rango de celdas
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}

function font_size($celda,$size){//Establece el tamaño de texto
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle($celda)->getFont()->setSize($size);
}

function anchocol($columna,$ancho){//Establece el ancho de columna
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($ancho);
}

function altofila($fila,$alto){//Establece el alto de la fila
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight($alto);
}

function ancho_auto($col1, $col2){//Establece el ancho de un rango de columnas automáticamente
    global $objPHPExcel;
    foreach(range($col1,$col2) as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }
}

function ancho_col_auto($col1){//Establece el ancho de un rango de columnas automáticamente
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getColumnDimension($col1)->setAutoSize(true);
}

function titulo_hoja($titulo){//Establece el titulo de la hoja activa
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->setTitle($titulo);
}

function set_hoja($index){//Cambia a la hoja indicada
    global $objPHPExcel;
    $objPHPExcel->setActiveSheetIndex($index);
}

function nueva_hoja(){//Añade una nueva hoja
    global $objPHPExcel;
    $objPHPExcel->createSheet();
}

function set_celda($celda){//Selecciona la celda indicada
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->setSelectedCell($celda);
}

function valor_celda($celda,$valor){//Establece el valor de la celda
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->setCellValue($celda, $valor);
}

function valor_celda_txt($celda,$valor){//Establece el valor de la celda como texto (admite ceros iniciales)
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->setCellValueExplicit($celda, $valor, PHPExcel_Cell_DataType::TYPE_STRING);
}

function coge_valor_celda($celda){//Obtiene el valor de la celda
    global $objPHPExcel;
    return $objPHPExcel->getActiveSheet()->getCell($celda)->getValue();
}

function coge_calculado_celda($celda){//Obtiene el valor de la celda
    global $objPHPExcel;
    return $objPHPExcel->getActiveSheet()->getCell($celda)->getCalculatedValue();
}

function combinar($celdas){//Combina las celdas (P.Ej.: A1:D1)
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->mergeCells($celdas);
}

function borde_fino($celdas,$borde){//Borde para la celda o rango ($borde= top, bottom, left, right o all)
    global $objPHPExcel;
    switch ($borde){
        case 'top':
            $pos='getTop';
            break;
        case 'bottom':
            $pos='getBottom';
            break;
        case 'left':
            $pos='getLeft';
            break;
        case 'right':
            $pos='getRight';
            break;
        case 'all':
            $pos='getAllBorders';
            break;
    }
    $objPHPExcel->getActiveSheet()->getStyle($celdas)->getBorders()->$pos()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
}

function borde_grueso($celdas,$borde){//Borde para la celda o rango ($borde= top, bottom, left, right o all)
    global $objPHPExcel;
    switch ($borde){
        case 'top':
            $pos='getTop';
            break;
        case 'bottom':
            $pos='getBottom';
            break;
        case 'left':
            $pos='getLeft';
            break;
        case 'right':
            $pos='getRight';
            break;
        case 'all':
            $pos='getAllBorders';
            break;
    }
    $objPHPExcel->getActiveSheet()->getStyle($celdas)->getBorders()->$pos()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
}

function moneda($dato,$decimales){//Devuelve el formato de moneda compatible con Excel con X decimales
    return number_format($dato,$decimales,'.','');
}

function ajusta_texto($celda){//Ajusta el texto de la celda
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setWrapText(true);
}

function alto_auto($fila1, $fila2){//Establece el alto de un rango de filas automáticamente
    global $objPHPExcel;
    foreach(range($fila1,$fila2) as $filaID) {
        $objPHPExcel->getActiveSheet()->getRowDimension($filaID)->setRowHeight(-1);
    }
}
function derecha($celda){//Alinea el texto de la celda o rango de celdas a la derecha
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
}

//********           FUNCIONES AÑADIDAS POR ELOY     ************************//

function centrado_vertical($celda){//Centra el texto de la celda o rango de celdas
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
}

function hipervinculo($celda,$url){//crea un hipervinculo en la celda indicada
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getCell($celda)->getHyperlink()->setUrl($url);
}

function fuente($celda,$fuente){//establece el color de texto de la celda
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle($celda)->applyFromArray(array('font'  => array('name' => $fuente)));
}
//********         fIN  FUNCIONES AÑADIDAS POR ELOY     ************************//

?>