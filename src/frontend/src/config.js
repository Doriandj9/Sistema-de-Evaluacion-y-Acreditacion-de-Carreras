/**
 * En esata seccion deben ir las variables globales que se utilizara 
 * dentro del proyecto en el forntend y exportarlas para luego ser 
 * usuadas en scripts, generalmente deben ir la informacion que puede
 * cambiar con el tiempo.
 */

// esta variable contendra los valores maximos y minimo
// para la evaluacion de evidencias cuantitativas se 
// usara para controlar las calificaciones

const CONTROL_MAX_MIN_CUANTITIVAS_EVIDENCIAS = {max: 10, min: 0};

// esta variable controlara las opciones de las
// evidencias cualitativas en el srcipt se utlizara
// tanto las claves como los valores, si cambia en algun momento
// los valores y los nombres de escribirlos correctamente

const CONTROL_MAX_MIN_CUALITATIVAS_EVIDENCIAS = {
    "No valido": '0%',
    "Bajo": '25%',
    "Medio": '50%',
    "Medio Alto": '75%',
    "Alto": '100%' 
};


// Aqui se exportan las variables:
export {CONTROL_MAX_MIN_CUALITATIVAS_EVIDENCIAS,CONTROL_MAX_MIN_CUANTITIVAS_EVIDENCIAS};