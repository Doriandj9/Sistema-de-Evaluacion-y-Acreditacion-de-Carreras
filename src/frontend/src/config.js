/**
 * En esata seccion deben ir las variables globales que se utilizara 
 * dentro del proyecto en el forntend y exportarlas para luego ser 
 * usuadas en scripts, generalmente deben ir la informacion que puede
 * cambiar con el tiempo.
 */

// esta variable contendra los valores maximos y minimo
// para la evaluacion de evidencias cuantitativas se 
// usara para controlar las calificaciones

const CONTROL_MAX_MIN_CUANTITIVAS_EVIDENCIAS = {max: 1, min: 0.00};

// esta variable controlara las opciones de las
// evidencias cualitativas en el srcipt se utlizara
// tanto las claves como los valores, si cambia en algun momento
// los valores y los nombres de escribirlos correctamente

const CONTROL_MAX_MIN_CUALITATIVAS_EVIDENCIAS = {
    "Sin Valoración": '0.00',
    "Deficiente": '0.20',
    "Poco Satisfactorio": '0.40',
    "Cuasi Satisfactorio": '0.80',
    "Satisfactorio": '1' 
};


// Aqui se exportan las variables:
export {CONTROL_MAX_MIN_CUALITATIVAS_EVIDENCIAS,CONTROL_MAX_MIN_CUANTITIVAS_EVIDENCIAS};