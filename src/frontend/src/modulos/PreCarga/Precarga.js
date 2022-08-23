
export default class Precarga extends HTMLElement{ 
    constructor(){
        super();
        this.attachShadow({mode: "open"});
        this.shadowRoot.append(Precarga.template.content.cloneNode(true));
        this.div = this.shadowRoot.querySelector('div');
        this.centro = this.shadowRoot.querySelector('span');

    }

    run(){
        document.body.append(this);
    }

    end(){
        this.remove();
    }
}


Precarga.template = document.createElement('template');

fetch('/src/frontend/src/modulos/PreCarga/template.html')
.then(cons => cons.text())
.then(text => {
    Precarga.template.innerHTML = text;
    customElements.define('precarga-componente',Precarga);
})