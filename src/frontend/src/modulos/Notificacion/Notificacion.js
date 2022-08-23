class Notificacion_Componente extends HTMLElement {

    constructor(){
        super();
        this.attachShadow({mode: "open"});
        this.shadowRoot.append(Notificacion_Componente.template.content.cloneNode(true));
        this.notificacion_content = this.shadowRoot.querySelector('.notificacion');
        this.notificacion = this.notificacion_content.querySelector('div');
        this.button = this.shadowRoot.querySelector('button');
        
        /**Creacion del boton */
        this.button.onclick = (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.remove();
        }
        
        document.addEventListener('keydown', e => {
            e.preventDefault();
            if(e.key === 'Enter'){
                this.remove();
            }
        },{once:true})
        
        
    }
    attributeChangedCallback(name,oldValue,newValue){
        if(name === 'mensaje'){
            this.notificacion.querySelector('p').prepend(document.createTextNode(newValue));
        }
        if(name === 'bg-color-notificacion'){
            this.notificacion.style.setProperty('--color-notification',newValue);

        }
        if(name === 'texto-boton'){
            this.button.textContent = newValue;

        }
        if(name === 'bg-color-boton'){
            this.button.style.backgroundColor = newValue;

        }
    }

   
}




Notificacion_Componente.template = document.createElement('template');
Notificacion_Componente.observedAttributes = ['mensaje','bg-color-notificacion','texto-boton','bg-color-boton'];

fetch('/src/frontend/src/modulos/Notificacion/template.html')
.then(res => res.text())
.then(text => {
    Notificacion_Componente.template.innerHTML = text
    customElements.define('notificacion-componente',Notificacion_Componente);
});

export default class Notificacion {
    constructor(mensaje,text_button,notificacion_error = true){
        let backgrod_color = '#D71043'
        let backgrod_color_button = '#35598D'
        if(!notificacion_error){
            backgrod_color_button = 'green';
            backgrod_color = '#35598D';
        }
        const notificacion_componente = document.createElement('notificacion-componente');
        notificacion_componente.setAttribute('mensaje',mensaje);
        notificacion_componente.setAttribute('bg-color-notificacion',backgrod_color);
        notificacion_componente.setAttribute('texto-boton',text_button);
        notificacion_componente.setAttribute('bg-color-boton',backgrod_color_button);
        notificacion_componente.addEventListener('keyadd', e =>{
            console.log('1231');
            console.log(e.detail);
        })
        document.body.prepend(notificacion_componente);
    }
}