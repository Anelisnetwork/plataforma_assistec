// Chat Widget Script con configuración dinámica
;(() => {
    /*
    ========================================================================================
    ==================================== CONFIGURACIONES ===================================
    ========================================================================================
    */

    // Configuración predeterminada del chatbot
    const defaultConfig = 
    {
        webhook: 
        {
          url: "https://chatassistec.app.n8n.cloud/webhook/af0b5b73-850a-4b70-b48a-3b7adc13d97d/chat",
          route: "general",
        },
        branding: 
        {
          logo: "https://assistec.es/wp-content/uploads/2023/06/assistec_logo1.png",
          name: "Assistec Re-evolution",
          initialMessage: "¡Hola! Soy EVO ASSIST 👋, el asistente de Assistec Re-evolution, entrenado para atenderte en todo lo que necesites.\n\nCuéntame, ¿en qué te puedo ayudar?",
          pendingResponseMessage: "¡Ahora te comento!",
          maintenanceMessage: "Lo sentimos, el chat está actualmente en mantenimiento. Por favor, inténtalo más tarde.",
          poweredBy: {
            text: "Desarrollado por Anelis Network",
            link: "https://anelis.com/",
          },
          poweredBy2: {
            text: "Política de privacidad",
            link: "https://assistec.es/aviso-legal/",
          },
          chatButtonText: "Enviar mensaje",
          inputPlaceholder: "Escribe tu mensaje aquí...",
          sendButtonText: "Enviar",
          errorMessage: "Lo siento, ha ocurrido un error al procesar tu mensaje. Por favor, inténtalo de nuevo más tarde.",
        },
        timing: 
        {
          initialDelay: 2000,
          betweenChunks: 3000,
          beforeNextChunk: 2000,
          betweenChunkProcess: 2000,
        },
        characterLimit: 110,
        enableMessageSplitting: true,
    };
      
  
    // Funcion para combinar las configuraciones del bot 
    const mergeDeep = (target, source) => 
    {
        const isObject = obj => obj && typeof obj === 'object' && !Array.isArray(obj);
        
        if (!isObject(target) || !isObject(source)) 
        {
            return source;
        }
        
        Object.keys(source).forEach(key => 
        {
            if (isObject(source[key])) 
            {
                if (!target[key]) Object.assign(target, { [key]: {} });
                mergeDeep(target[key], source[key]);
            } 
            else 
            {
                Object.assign(target, { [key]: source[key] });
            }
        });
        
        return target;
    };
    
    const config = window.ChatWidgetConfig ? mergeDeep(JSON.parse(JSON.stringify(defaultConfig)), window.ChatWidgetConfig) : defaultConfig;
  
    if (window.N8NChatWidgetInitialized) return;
    window.N8NChatWidgetInitialized = true;


    /*
    ========================================================================================
    ============================== DEFINICIONES DE VARIABLES ==============================
    ========================================================================================
    */

    // ====== ELEMENTOS HTML ====== 
    const chatInterfaceHTML = `
    <div class="chat-interface">
        <div class="brand-header">
            <div class="brand-info">
                <svg class="bot-icon" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 20 20">
                    <g transform="translate(-25.414562,-111.28127)">
                    <path fill="#BEBEBE" d="m 35.412312,115.5918 c -1.442046,0 -2.880739,0.49168 -4.052401,1.4748 -0.705182,0.59173 -1.2502,1.31171 -1.628713,2.10012 -0.05253,-0.005 -0.103652,-0.0164 -0.157588,-0.0164 -0.941869,0 -1.70024,0.75836 -1.70024,1.70021 v 2.10134 c 0,0.94184 0.758371,1.70021 1.70024,1.70021 0.05394,0 0.105059,-0.0117 0.157588,-0.0164 0.06777,0.14047 0.137889,0.27991 0.216918,0.41689 0.308938,0.55139 1.134304,0.0793 0.815588,-0.46655 -1.304955,-2.26029 -0.799571,-5.12447 1.199708,-6.80208 1.999326,-1.67765 4.903352,-1.67765 6.902655,0 1.999326,1.67761 2.50471,4.54174 1.199732,6.80208 l -0.01407,0.0234 -0.0094,0.0234 c 0,0 -0.633799,1.40211 -1.878344,1.40211 l -1.575387,-0.0141 c -0.147739,-0.21575 -0.384191,-0.366 -0.666512,-0.366 h -1.015533 c -0.45534,0 -0.821638,0.36752 -0.821638,0.82286 0,0.28087 0.178225,0.49415 0.586056,0.49415 l 3.493009,0.00028 c 1.867604,0 2.675336,-1.8335 2.712107,-1.91835 v -0.005 c 0.07832,-0.13578 0.147269,-0.27521 0.214572,-0.41444 0.05488,0.005 0.108342,0.0164 0.164858,0.0164 0.941869,0 1.700237,-0.75836 1.700237,-1.70021 v -2.10134 c 0,-0.94184 -0.75837,-1.70021 -1.700237,-1.70021 -0.05441,0 -0.105762,0.009 -0.158761,0.0164 -0.377627,-0.78846 -0.921023,-1.50837 -1.6263,-2.10014 -1.171614,-0.98312 -2.616355,-1.47481 -4.058451,-1.47481 z m -2.049205,2.98718 c -0.366019,-0.0239 -0.700354,0.0535 -0.992502,0.36114 -0.779049,0.82018 -1.260325,1.9365 -1.260325,3.12533 0,0.98061 0.327722,2.07941 0.879793,2.11951 0.786511,0.0572 2.027657,-0.45928 3.424676,-0.45928 1.480437,0 2.786843,0.57951 3.561606,0.44232 0.469528,-0.083 0.744064,-1.20536 0.744064,-2.10255 0,-1.18883 -0.482452,-2.30515 -1.261524,-3.12533 -0.779054,-0.82021 -1.855342,0 -3.044146,0 -0.743006,0 -1.441646,-0.32109 -2.051642,-0.36114 z m -0.174473,2.02134 c 0.434305,0.00017 0.786345,0.35219 0.786486,0.78651 -0.000141,0.43431 -0.352181,0.78633 -0.786486,0.78649 -0.434304,-0.00016 -0.786345,-0.35218 -0.786485,-0.78649 0.00014,-0.43432 0.352181,-0.78634 0.786485,-0.78651 z m 4.452304,0 c 0.434329,0.00017 0.786345,0.35219 0.786509,0.78651 -0.000166,0.43431 -0.35218,0.78633 -0.786509,0.78649 -0.434304,-0.00016 -0.786321,-0.35218 -0.786485,-0.78649 0.000164,-0.43432 0.352181,-0.78634 0.786485,-0.78651 z"/>
                </svg>
                <div class="bot-name">
                    <p><span>SandroBot</span> - Asistente Virtual</p>
                    <div class="status-container">
                        <div class="status-light online"></div>
                        <div class="status-text">Disponible Ahora</div>
                    </div>
                </div>
            </div>
            <button class="close-button">&times;</button>
        </div>
        <div class="chat-messages"></div>
        <div class="chat-input">
            <div class="new-conversation">
                <div class="new-chat-btn"></div>
            </div>
            <textarea placeholder="${config.branding.inputPlaceholder}" rows="1"></textarea>
            <button type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
                <span class="sr-only">${config.branding.sendButtonText}</span>
            </button>
        </div>
        <div class="chat-footer">
            <a href="${config.branding.poweredBy.link}" target="_blank">${config.branding.poweredBy.text}</a> - 
            <a href="${config.branding.poweredBy2.link}" target="_blank">${config.branding.poweredBy2.text}</a>
        </div>
    </div>`;

    const formularioHTML = `
    <div id="formulario-profesional">
        <form id="form-contacto">
            <h5>Rellena el formulario y en breve un miembro de nuestro equipo te atenderá.</h5>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" required>
            <input type="email" name="email" id="email" placeholder="Correo electrónico" required>
            <input type="tel" name="telefono" id="telefono" placeholder="Teléfono" required>
            <label for="horario">Horario preferente de contacto:</label>
            <select id="hora" name="hora">
                <option value="09:00">09:00</option>
                <option value="09:30">09:30</option>
                <option value="10:00">10:00</option>
                <option value="10:30">10:30</option>
                <option value="11:00">11:00</option>
                <option value="11:30">11:30</option>
                <option value="12:00">12:00</option>
                <option value="12:30">12:30</option>
                <option value="13:00">13:00</option>
                <option value="13:30">13:30</option>
                <option value="15:00">15:00</option>
                <option value="15:30">15:30</option>
                <option value="16:00">16:00</option>
                <option value="16:30">16:30</option>
                <option value="17:00">17:00</option>
                <option value="17:30">17:30</option>
            </select>
            <button type="submit">Enviar</button>
            <input type="hidden" name="sesion" id="sesion" value="">
            <input type="hidden" name="conversacion" id="conversacion" value="">
            <button type="button" id="cerrar-formulario">Cancelar</button>
        </form>
    </div>`;

    const toggleButtonIcono = `
    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 20 20">
      <g transform="translate(-25.414562,-111.28127)">
        <path fill="#ffffff" d="m 35.412312,115.5918 c -1.442046,0 -2.880739,0.49168 -4.052401,1.4748 -0.705182,0.59173 -1.2502,1.31171 -1.628713,2.10012 -0.05253,-0.005 -0.103652,-0.0164 -0.157588,-0.0164 -0.941869,0 -1.70024,0.75836 -1.70024,1.70021 v 2.10134 c 0,0.94184 0.758371,1.70021 1.70024,1.70021 0.05394,0 0.105059,-0.0117 0.157588,-0.0164 0.06777,0.14047 0.137889,0.27991 0.216918,0.41689 0.308938,0.55139 1.134304,0.0793 0.815588,-0.46655 -1.304955,-2.26029 -0.799571,-5.12447 1.199708,-6.80208 1.999326,-1.67765 4.903352,-1.67765 6.902655,0 1.999326,1.67761 2.50471,4.54174 1.199732,6.80208 l -0.01407,0.0234 -0.0094,0.0234 c 0,0 -0.633799,1.40211 -1.878344,1.40211 l -1.575387,-0.0141 c -0.147739,-0.21575 -0.384191,-0.366 -0.666512,-0.366 h -1.015533 c -0.45534,0 -0.821638,0.36752 -0.821638,0.82286 0,0.28087 0.178225,0.49415 0.586056,0.49415 l 3.493009,0.00028 c 1.867604,0 2.675336,-1.8335 2.712107,-1.91835 v -0.005 c 0.07832,-0.13578 0.147269,-0.27521 0.214572,-0.41444 0.05488,0.005 0.108342,0.0164 0.164858,0.0164 0.941869,0 1.700237,-0.75836 1.700237,-1.70021 v -2.10134 c 0,-0.94184 -0.75837,-1.70021 -1.700237,-1.70021 -0.05441,0 -0.105762,0.009 -0.158761,0.0164 -0.377627,-0.78846 -0.921023,-1.50837 -1.6263,-2.10014 -1.171614,-0.98312 -2.616355,-1.47481 -4.058451,-1.47481 z m -2.049205,2.98718 c -0.366019,-0.0239 -0.700354,0.0535 -0.992502,0.36114 -0.779049,0.82018 -1.260325,1.9365 -1.260325,3.12533 0,0.98061 0.327722,2.07941 0.879793,2.11951 0.786511,0.0572 2.027657,-0.45928 3.424676,-0.45928 1.480437,0 2.786843,0.57951 3.561606,0.44232 0.469528,-0.083 0.744064,-1.20536 0.744064,-2.10255 0,-1.18883 -0.482452,-2.30515 -1.261524,-3.12533 -0.779054,-0.82021 -1.855342,0 -3.044146,0 -0.743006,0 -1.441646,-0.32109 -2.051642,-0.36114 z m -0.174473,2.02134 c 0.434305,0.00017 0.786345,0.35219 0.786486,0.78651 -0.000141,0.43431 -0.352181,0.78633 -0.786486,0.78649 -0.434304,-0.00016 -0.786345,-0.35218 -0.786485,-0.78649 0.00014,-0.43432 0.352181,-0.78634 0.786485,-0.78651 z m 4.452304,0 c 0.434329,0.00017 0.786345,0.35219 0.786509,0.78651 -0.000166,0.43431 -0.35218,0.78633 -0.786509,0.78649 -0.434304,-0.00016 -0.786321,-0.35218 -0.786485,-0.78649 0.000164,-0.43432 0.352181,-0.78634 0.786485,-0.78651 z"/>
    </svg>`;

    /*
        ====== LOCAL STORAGE ====== 
    */
    let currentSessionId = localStorage.getItem('chatbotSessionId');
    let currentDate = localStorage.getItem('currentDate');
    let recentMessages = JSON.parse(localStorage.getItem('recentMessages'));

    const now = Date.now();
    const MILISEGUNDOS_EN_24_HORAS = 24 * 60 * 60 * 1000;

    if (!currentDate || now - parseInt(currentDate) > MILISEGUNDOS_EN_24_HORAS || !recentMessages) 
    {
        currentSessionId = generateUUID();
        currentDate = now.toString();
        recentMessages = [];

        localStorage.setItem('chatbotSessionId', currentSessionId);
        localStorage.setItem('currentDate', currentDate);
    }
    
    /*
        ====== ESTILOS Y COMPONENTES ====== 
    */
    const fontLink = document.createElement("link");
    fontLink.rel = "stylesheet";
    fontLink.href = "https://cdn.jsdelivr.net/npm/geist@1.0.0/dist/fonts/geist-sans/style.css";
    document.head.appendChild(fontLink);
  
    const widgetContainer = document.createElement("div");
    widgetContainer.className = "n8n-chat-widget";
  
    const chatContainer = document.createElement("div");
    chatContainer.className = "chat-container";  

    chatContainer.innerHTML = chatInterfaceHTML;
  
    const toggleButton = document.createElement("button");
    
    toggleButton.className = "chat-toggle";
    toggleButton.innerHTML = toggleButtonIcono;

    widgetContainer.appendChild(chatContainer);
    widgetContainer.appendChild(toggleButton);
    document.body.appendChild(widgetContainer);

    chatContainer.querySelector('.chat-interface').insertAdjacentHTML('beforeend', formularioHTML);
  
    const chatInterface = chatContainer.querySelector(".chat-interface");
    const messagesContainer = chatContainer.querySelector(".chat-messages");
    const textarea = chatContainer.querySelector("textarea");
    textarea.disabled = true;
    textarea.classList.add('disabled');
    const sendButton = chatContainer.querySelector('button[type="submit"]');
    
    /*
    ========================================================================================
    ======================================= FUNCIONES ======================================
    ========================================================================================
    */

    // Genera el id de la sesión para el usuario
    function generateUUID() 
    {
       return crypto.randomUUID ? crypto.randomUUID() : 
       ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
            (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
        );
    }


    // Crea el elemento del chat para simular que el bot esté tecleando
    function showTypingIndicator() 
    {
        const typingIndicator = document.createElement("div");
        typingIndicator.className = "typing-indicator";
        typingIndicator.innerHTML = `
        <span></span>
        <span></span>
        <span></span>
        `;
        typingIndicator.id = "typing-indicator";
        messagesContainer.appendChild(typingIndicator);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        return typingIndicator;
    }


    // Elimina el elemento de indicador
    function removeTypingIndicator() 
    {
        const typingIndicator = document.getElementById("typing-indicator");
        if (typingIndicator) 
            typingIndicator.remove();
    }


    // Muestra la animacion de cargar
    function showLoadingSpinner() 
    {
        const overlay = document.createElement("div");
        const spinner = document.createElement("div");
        overlay.className = "loading-overlay";
        spinner.className = "loading-spinner";
        spinner.innerHTML = `<div class="spinner"></div>`;
        overlay.appendChild(spinner);
        messagesContainer.appendChild(overlay);
    }


    // Elimina la animacion de cargar 
    function removeLoadingSpinner() 
    {
        const spinner = document.querySelector(".loading-overlay");
        if (spinner) {
            spinner.remove();
            messagesContainer.style.overflowY = "auto";
        }
    }

    // Muestra el formulario
    function mostrarFormulario() 
    {
        document.getElementById('formulario-profesional').style.display = 'flex';
        setTimeout(() => 
        {
            document.getElementById('formulario-profesional').style.opacity = '1';
        }, 
        500)
    }

    function toggleInput(){
        textarea.disabled = !textarea.disabled;
        textarea.classList.toggle('disabled');
    }

    // Crea el elemento del mensaje con el contenido del mensaje que se le pasa para el bot
    function addBotMessage(message) 
    {
      const botMessageDiv = document.createElement("div");
      botMessageDiv.className = "chat-message bot";
      botMessageDiv.textContent = message;
      messagesContainer.appendChild(botMessageDiv);
      messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Crea el elemento del mensaje con el contenido del mensaje que se le pasa para el usuario
    function addUserMessage(message) 
    {
        const userMessageDiv = document.createElement("div");
        userMessageDiv.className = "chat-message user";
        userMessageDiv.textContent = message;
        messagesContainer.appendChild(userMessageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
  
    /*  
        Separa el mensaje en bloques respetando solo los saltos de línea y el límite de carácteres.

        1) Se divide el mensaje por párrafos (múltiples saltos de línea) para mantener bloques lógicos.
        2) Dentro de cada párrafo, se agrupan líneas consecutivas sin superar el límite de carácteres.

        Devuelve un array de los mensajes separados.
    */
    function splitMessageIntelligently(message, characterLimit) 
    {
        const sections = message.split(/\n\n+/).filter(s => s.length > 0 && s.trim() !== "");

        const chunks = [];

        for (const section of sections) {
            const lines = section.split(/\n/);
            let currentChunk = "";

            for (const line of lines) 
            {
                if (currentChunk && currentChunk.length + line.length + 1 > characterLimit) 
                {
                    chunks.push(currentChunk);
                    currentChunk = line;
                } 
                else 
                {
                    if (currentChunk) 
                    {
                        currentChunk += "\n";
                    }
                    currentChunk += line;
                }
            }

            if (currentChunk) 
            {
                chunks.push(currentChunk);
            }
        }

        return chunks;
    }
        

    /* 
        Combina la funcionalidad de la creacion de los elementos de los mensajes, y la separacion del mensaje inteligente con tiempo de espera entre cada mensaje utilizando el indicador de teclear

        Se utiliza la funcion para separar el mensaje en bloques, y se va creando y añadiendo elementos para cada bloque, con un retraso y el indicador para simular que el bot esté tecleando cada mensaje naturalmente. 

        Acepta un argumento para cargar los mensajes sin el retraso que por defecto es falso

        Devuelve una promesa que indica cuando ha termiado de procesar todos los bloques
    */
    function addBotMessageWithIntelligentSplitting(message, skipTiming = false) 
    {
        return new Promise((resolve) => 
        {
            if (!config.enableMessageSplitting || message.length <= config.characterLimit) 
            {
                addBotMessage(message);
                resolve(); 
                return;
            }
    
            const chunks = splitMessageIntelligently(message, config.characterLimit);

            if (skipTiming) {
                for (const chunk of chunks) {
                    addBotMessage(chunk.trim());
                }
                resolve();
                return;
            }

            addBotMessage(chunks[0]);
    
            let chunkIndex = 1;
    
            function addNextChunk() 
            {
                if (chunkIndex >= chunks.length)
                {
                    resolve(); 
                    return;
                }
    
                showTypingIndicator();
    
                setTimeout(() => 
                {
                    removeTypingIndicator();
                    
                    let chunkText = chunks[chunkIndex];
                    if (chunkIndex > 0) 
                        chunkText = chunkText.replace(/^\s+/, '');
    
                    addBotMessage(chunkText);
                    chunkIndex++;
    
                    if (chunkIndex < chunks.length) 
                        setTimeout(addNextChunk, config.timing.betweenChunkProcess);
                    else 
                        resolve(); 
                }, 
                config.timing.betweenChunks * ((Math.log((chunks[chunkIndex].length / 30) + 1)) * 0.8) + ((chunks[chunkIndex].length / 30) * 0.2));
            }
            setTimeout(addNextChunk, config.timing.beforeNextChunk);
        });
    }
    

    // Crea y muestra los mensajes de inicio al abrir el contendor de la conversacion utilizando el indicador de teclear, y la separacion del mensaje inteligente
    function addInitialMessage() 
    {
        showTypingIndicator();
      
        setTimeout(async () => 
        {
            removeTypingIndicator();
            await addBotMessageWithIntelligentSplitting(config.branding.initialMessage);
            toggleInput();
        }, 
        config.timing.initialDelay);
    }
    

    // Genera todos los mensajes anteriores entre el bot y usuario como estaban en la conversacion original, utilizando la separacion del mensaje inteligente
    function addPreviousConversation(conversation) 
    {
        return new Promise(async (resolve) => 
        {
            const messages = conversation.split("\n"); 

            addBotMessageWithIntelligentSplitting(config.branding.initialMessage, true);
        
            for (const message of messages) 
            {
                if (message.startsWith("Usuario:")) 
                    addUserMessage(message.replace("Usuario: ", "").trim());

                else if (message.startsWith("Bot:")) 
                    await addBotMessageWithIntelligentSplitting(message.replace("Bot: ", "").trim(), true);
            }
            resolve(); 
        });
    }

    /* 
        Extrae todos los mensajes de la conversación en el formato para la base de datos:

        Bot: Mensaje
        Usuario: Mensaje
    */
    function obtenerConversacionCompleta() 
    {
        const mensajes = document.querySelectorAll(".chat-message");
        let conversacion = "";
        mensajes.forEach(mensaje => 
        {
            if (mensaje.textContent.includes("Enviando..."))
                return;
            let remitente = mensaje.classList.contains("user") ? "Usuario: " : "Bot: ";
            conversacion += remitente + mensaje.textContent + "\n";
        });
        return conversacion.trim();
    }

  
    /*
    ========================================================================================
    ================================= FUNCIONES ASINCRONOS =================================
    ========================================================================================
    */


    /* 
        Configura el chat al pulsar el boton, creando una id de la sesión y un contador de cuando se caduca. 

        Despues de crear la id de sesión se abre la interfaz del chat, realiza una peticion ajax a la IA para cargar conversaciones previas si las hay, y dispone los mensajes iniciales

        Llamada por el boton de nuevo chat 
    */
    async function startNewConversation() 
    {  
        if ( !currentSessionId )
        {
            currentSessionId = generateUUID();
            localStorage.setItem('currentSessionId', currentSessionId);
        }

        if (!currentDate) 
        {
            currentDate = new Date().toLocaleString();
            localStorage.setItem('currentDate', currentDate);
        }

        chatContainer.querySelector(".new-conversation").style.display = "none";
        chatInterface.classList.add("active");

        showLoadingSpinner();

        const data = {
            dataUser: sessionStorage.getItem("datos_ASSISTEC"),
        };

        
        fetch("https://chatassistec.app.n8n.cloud/webhook/31b96ff9-14f9-40bd-bbb8-28ecb1a3b9bd", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(responseData => {
            const serverMessage = responseData.conversacion; 

            if (serverMessage && serverMessage.trim() !== ""){
                addPreviousConversation(serverMessage).then(() => {
                    removeLoadingSpinner(); 
                    toggleInput();
                });
            }
            else {
                removeLoadingSpinner();
                addInitialMessage();
            }

        })
        .catch(error => {
            console.error("Error:", error)
            document.querySelector('.status-light').classList.remove('online');
            document.querySelector('.status-light').classList.add('offline');
            document.querySelector('.status-text').textContent = 'No disponible'
        });
    }


    /*
       Crea el elemento del mensaje de usuario y se envía una peticion ajax al servidor con la IA para recibir la respuesta, mostrando el indicador de teclear en el tiempo de espera
       
       Al recibir la respuesta de la IA, parsea el JSON y comprueba si tiene que mostrar el formulario o no.

       Si hay que mostrar el formulario, muestra los siguentes mensajes con un retraso entre el fin del mensaje y la muestra del formulario
       
       Si no, muestra la respuesta de la IA con la separacion de mensajes inteligente
    */
    async function sendMessage(message) 
    {
        if (recentMessages.length >= 5) {
            recentMessages.shift();
        }
        recentMessages.push(message);
        localStorage.setItem('recentMessages', JSON.stringify(recentMessages));

        const messageData = {
            action: "sendMessage",
            sessionId: currentSessionId,
            route: config.webhook.route,
            chatInput: message,
            recentMessages: JSON.stringify(recentMessages),
            metadata: { userId: "", },
        };

        textarea.disabled = true;
        textarea.classList.toggle('disabled');
    
        addUserMessage(message);
    
        showTypingIndicator();
        if (recentMessages.length < 2) {
            setTimeout(() => {
                removeTypingIndicator();
                addBotMessage(config.branding.pendingResponseMessage);
                setTimeout(showTypingIndicator, config.timing.beforeNextChunk)
            }, config.timing.initialDelay)
        }
    
        if (config.webhook.url) 
        {
            try 
            {
                const response = await fetch(config.webhook.url, 
                {
                    method: "POST",
                    headers: { "Content-Type": "application/json", },
                    body: JSON.stringify(messageData),
                });
    
                const data = await response.json();
                const serverMessage = data.output;
    
                setTimeout(() => {
                    removeTypingIndicator();
                    if (data.mostrarFormulario == true)
                    {
                        removeTypingIndicator();
                        addBotMessageWithIntelligentSplitting(serverMessage).then(() => {
                            textarea.disabled = false;
                            textarea.classList.toggle('disabled');
                            setTimeout(() => {
                                mostrarFormulario();  
                            }, 2000);
                        });

                        return; 
                    }
                    else if (serverMessage && serverMessage.trim() !== "") 
                    {
                        addBotMessageWithIntelligentSplitting(serverMessage).then(() => {
                            textarea.disabled = false;
                            textarea.classList.toggle('disabled');
                        });
                    }
                }, 1000);
            } 
            catch (error) 
            {
                console.error("Error:", error);
                setTimeout(() => {
                    removeTypingIndicator();
                    addBotMessageWithIntelligentSplitting(config.branding.errorMessage);
                }, 1000);
            }
        } else {
            setTimeout(removeTypingIndicator, 1000);
        }
    }

    function toggleInterface() {
        if (!chatContainer.classList.contains("open"))     
            {
                chatContainer.classList.add("open");
                chatInterface.classList.add("active");
                if (!chatContainer.dataset.started) 
                {
                  startNewConversation();
                  chatContainer.dataset.started = "true";
                }
                toggleButton.classList.add("remove");
            } 
            else {
                chatContainer.classList.remove("open");
                toggleButton.classList.remove("remove");
            }
    }
  
    /*
    ========================================================================================
    ================================= EVENT LISTENERS =================================
    ========================================================================================
    */

    // Se envía el mensaje
    sendButton.addEventListener("click", () => {
      const message = textarea.value.trim();
      if (message) {
        sendMessage(message);
        textarea.value = "";
      }
    });
  
    // Se envía el mensaje si el usuario pulsa "Enter"
    textarea.addEventListener("keypress", (e) => {
      if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault();
        const message = textarea.value.trim();
        if (message) {
          sendMessage(message);
          textarea.value = "";
        }
      }
    });

    // Boton para abrir la interfaz, empezar la conversacion y cambiar el estilo del boton. 
    toggleButton.addEventListener("click", toggleInterface);
  
    const closeButton = chatContainer.querySelector(".close-button");

    closeButton.addEventListener("click", toggleInterface);

    // Cerrar formulario
    document.getElementById('cerrar-formulario').addEventListener('click', () => {
        document.getElementById('formulario-profesional').style.display = 'none';
        document.getElementById('formulario-profesional').style.opacity = '0';
    });

    // Combinar los datos del formulario con el id de la sesión y los mensajes de la conversacion y enviarlos al webhook. 
    document.getElementById('form-contacto').addEventListener('submit', function(e) 
    {
        e.preventDefault();
        toggleInput(); 
        addBotMessage("Enviando...");
        let mensajeSistema = document.querySelector('.chat-message.bot:last-of-type');
    
        const datos = {
            id: currentSessionId,
            nombre: document.getElementById('nombre').value,
            email: document.getElementById('email').value,
            telefono: document.getElementById('telefono').value,
            hora_preferencia: document.getElementById('hora').value,
            mensajes: obtenerConversacionCompleta(),
        };

        const webhookURL = 'https://chatassistec.app.n8n.cloud/webhook/31b96ff9-14f9-40bd-bbb8-28ecb1a3b9bd';
    
        fetch(webhookURL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datos)
        })
        .then(res => {
            if(res.ok){
                setTimeout(() => {
                    mensajeSistema.textContent = "¡Gracias! En breve alguien se pondrá en contacto contigo. ¿Tienes alguna otra pregunta?";
                    toggleInput();
                }, 3000)
            }  
            else{
                addBotMessage("Error al enviar. Inténtalo nuevamente.");
            } 
        })
        .catch(err => {
            console.error(err);
            addBotMessage("Error inesperado al enviar el formulario.");
        });
    
        document.getElementById('formulario-profesional').style.opacity = '0';
        document.getElementById('formulario-profesional').style.display = 'none';
    });

})();
