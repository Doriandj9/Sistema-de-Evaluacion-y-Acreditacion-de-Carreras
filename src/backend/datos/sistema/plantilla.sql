--
-- PostgreSQL database dump
--

-- Dumped from database version 12.1
-- Dumped by pg_dump version 12.1

-- Started on 2023-01-25 14:43:17

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 203 (class 1259 OID 82610)
-- Name: carreras; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carreras (
    id character(8) NOT NULL,
    nombre text NOT NULL,
    id_facultad character(8) NOT NULL,
    numero_asig integer NOT NULL,
    total_horas_proyecto integer NOT NULL
);


ALTER TABLE public.carreras OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 82873)
-- Name: carreras_evidencias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carreras_evidencias (
    id_periodo_academico character(10) NOT NULL,
    id_evidencias text NOT NULL,
    id_carrera character(8) NOT NULL,
    cod_evidencia character(50) NOT NULL,
    fecha_inicial date,
    fecha_final date,
    pdf text,
    estado character(20),
    fecha_registro date,
    id_responsable character(10),
    nombre_documento text,
    valoracion text,
    comentario text,
    verificada boolean
);


ALTER TABLE public.carreras_evidencias OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 82765)
-- Name: carreras_periodo_academico; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carreras_periodo_academico (
    id_carreras character(8) NOT NULL,
    id_periodo_academico character(10) NOT NULL
);


ALTER TABLE public.carreras_periodo_academico OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 156424)
-- Name: componente_elemento_fundamental; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.componente_elemento_fundamental (
    id bigint NOT NULL,
    id_componente integer NOT NULL,
    id_elemento character(15) NOT NULL,
    descripcion text NOT NULL
);


ALTER TABLE public.componente_elemento_fundamental OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 156422)
-- Name: componente_elemento_fundamental_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.componente_elemento_fundamental_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.componente_elemento_fundamental_id_seq OWNER TO postgres;

--
-- TOC entry 3065 (class 0 OID 0)
-- Dependencies: 224
-- Name: componente_elemento_fundamental_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.componente_elemento_fundamental_id_seq OWNED BY public.componente_elemento_fundamental.id;


--
-- TOC entry 211 (class 1259 OID 82690)
-- Name: criterios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.criterios (
    id character(15) NOT NULL,
    nombre character(120) NOT NULL
);


ALTER TABLE public.criterios OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 82623)
-- Name: docentes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.docentes (
    id character(10) NOT NULL,
    nombre text NOT NULL,
    correo text NOT NULL,
    clave character(500),
    telefono character(10),
    cambio_clave boolean NOT NULL,
    apellido text NOT NULL
);


ALTER TABLE public.docentes OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 90791)
-- Name: docentes_carreras; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.docentes_carreras (
    id_carreras character(8) NOT NULL,
    id_docentes character(10) NOT NULL
);


ALTER TABLE public.docentes_carreras OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 82674)
-- Name: elemento_fundamental; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.elemento_fundamental (
    id character(15) NOT NULL,
    descripcion text NOT NULL,
    id_estandar character(15) NOT NULL
);


ALTER TABLE public.elemento_fundamental OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 82682)
-- Name: estandar; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.estandar (
    id character(15) NOT NULL,
    descripcion text NOT NULL,
    id_criterio character(15) NOT NULL,
    nombre character(200) NOT NULL,
    tipo character(15) NOT NULL
);


ALTER TABLE public.estandar OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 82844)
-- Name: evaluacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.evaluacion (
    id bigint NOT NULL,
    nota text NOT NULL,
    observacion text NOT NULL
);


ALTER TABLE public.evaluacion OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 82855)
-- Name: evaluacion_docentes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.evaluacion_docentes (
    id_evaluacion bigint NOT NULL,
    id_docente character(10) NOT NULL
);


ALTER TABLE public.evaluacion_docentes OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 82842)
-- Name: evaluacion_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.evaluacion_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.evaluacion_id_seq OWNER TO postgres;

--
-- TOC entry 3066 (class 0 OID 0)
-- Dependencies: 217
-- Name: evaluacion_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.evaluacion_id_seq OWNED BY public.evaluacion.id;


--
-- TOC entry 219 (class 1259 OID 82853)
-- Name: evalucion_docentes_id_evaluacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.evalucion_docentes_id_evaluacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.evalucion_docentes_id_evaluacion_seq OWNER TO postgres;

--
-- TOC entry 3067 (class 0 OID 0)
-- Dependencies: 219
-- Name: evalucion_docentes_id_evaluacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.evalucion_docentes_id_evaluacion_seq OWNED BY public.evaluacion_docentes.id_evaluacion;


--
-- TOC entry 226 (class 1259 OID 156435)
-- Name: evidencia_componente_elemento_fundamental; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.evidencia_componente_elemento_fundamental (
    id_evidencias text NOT NULL,
    id_componente integer NOT NULL
);


ALTER TABLE public.evidencia_componente_elemento_fundamental OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 82666)
-- Name: evidencias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.evidencias (
    id text NOT NULL,
    nombre text NOT NULL
);


ALTER TABLE public.evidencias OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 197390)
-- Name: evidencias_evaluacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.evidencias_evaluacion (
    id_evidencia text NOT NULL,
    id_carrera character(8) NOT NULL,
    id_periodo character(10) NOT NULL,
    id_evaluacion bigint NOT NULL
);


ALTER TABLE public.evidencias_evaluacion OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 197388)
-- Name: evidencias_evaluacion_id_evaluacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.evidencias_evaluacion_id_evaluacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.evidencias_evaluacion_id_evaluacion_seq OWNER TO postgres;

--
-- TOC entry 3068 (class 0 OID 0)
-- Dependencies: 231
-- Name: evidencias_evaluacion_id_evaluacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.evidencias_evaluacion_id_evaluacion_seq OWNED BY public.evidencias_evaluacion.id_evaluacion;


--
-- TOC entry 202 (class 1259 OID 82602)
-- Name: facultad; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.facultad (
    id character(8) NOT NULL,
    nombre text NOT NULL
);


ALTER TABLE public.facultad OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 221908)
-- Name: notificaciones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notificaciones (
    id bigint NOT NULL,
    remitente character(10) NOT NULL,
    receptor character(10) NOT NULL,
    mensaje text NOT NULL,
    id_carrera character(8) NOT NULL,
    leido boolean,
    mostrar boolean,
    fecha timestamp without time zone NOT NULL
);


ALTER TABLE public.notificaciones OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 221906)
-- Name: notificaciones_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notificaciones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notificaciones_id_seq OWNER TO postgres;

--
-- TOC entry 3069 (class 0 OID 0)
-- Dependencies: 233
-- Name: notificaciones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notificaciones_id_seq OWNED BY public.notificaciones.id;


--
-- TOC entry 216 (class 1259 OID 82782)
-- Name: periodo_academico_usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.periodo_academico_usuarios (
    id_periodo_academico character(10) NOT NULL,
    id_usuarios integer NOT NULL
);


ALTER TABLE public.periodo_academico_usuarios OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 82780)
-- Name: periodo_academico_usuarios_id_usuarios_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.periodo_academico_usuarios_id_usuarios_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.periodo_academico_usuarios_id_usuarios_seq OWNER TO postgres;

--
-- TOC entry 3070 (class 0 OID 0)
-- Dependencies: 215
-- Name: periodo_academico_usuarios_id_usuarios_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.periodo_academico_usuarios_id_usuarios_seq OWNED BY public.periodo_academico_usuarios.id_usuarios;


--
-- TOC entry 205 (class 1259 OID 82631)
-- Name: periodo_academicos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.periodo_academicos (
    id character(10) NOT NULL,
    fecha_inicial date NOT NULL,
    fecha_final date NOT NULL
);


ALTER TABLE public.periodo_academicos OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 180939)
-- Name: responsabilidad; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.responsabilidad (
    id integer NOT NULL,
    nombre text NOT NULL,
    id_criterio character(15) NOT NULL
);


ALTER TABLE public.responsabilidad OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 180937)
-- Name: responsabilidad_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.responsabilidad_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.responsabilidad_id_seq OWNER TO postgres;

--
-- TOC entry 3071 (class 0 OID 0)
-- Dependencies: 227
-- Name: responsabilidad_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.responsabilidad_id_seq OWNED BY public.responsabilidad.id;


--
-- TOC entry 213 (class 1259 OID 82750)
-- Name: titulos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.titulos (
    id bigint NOT NULL,
    nombre text NOT NULL,
    id_docente character(10) NOT NULL
);


ALTER TABLE public.titulos OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 82748)
-- Name: titulos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.titulos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.titulos_id_seq OWNER TO postgres;

--
-- TOC entry 3072 (class 0 OID 0)
-- Dependencies: 212
-- Name: titulos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.titulos_id_seq OWNED BY public.titulos.id;


--
-- TOC entry 207 (class 1259 OID 82638)
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    descripcion text NOT NULL,
    permisos bigint
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 107211)
-- Name: usuarios_docente; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios_docente (
    id_usuarios integer NOT NULL,
    id_docentes character(10) NOT NULL,
    id_carrera character(8) NOT NULL,
    fecha_inicial date NOT NULL,
    fecha_final date NOT NULL,
    estado character(10) NOT NULL,
    carrera text
);


ALTER TABLE public.usuarios_docente OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 82636)
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuarios_id_seq OWNER TO postgres;

--
-- TOC entry 3073 (class 0 OID 0)
-- Dependencies: 206
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- TOC entry 230 (class 1259 OID 180955)
-- Name: usuarios_responsabilidad; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios_responsabilidad (
    id_usuarios integer NOT NULL,
    id_responsabilidad integer NOT NULL,
    id_docentes character(10) NOT NULL,
    id_carrera character(8) NOT NULL,
    id_periodo_academico character(10) NOT NULL,
    fecha_inicial date,
    fecha_final date
);


ALTER TABLE public.usuarios_responsabilidad OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 180953)
-- Name: usuarios_responsabilidad_id_responsabilidad_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_responsabilidad_id_responsabilidad_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuarios_responsabilidad_id_responsabilidad_seq OWNER TO postgres;

--
-- TOC entry 3074 (class 0 OID 0)
-- Dependencies: 229
-- Name: usuarios_responsabilidad_id_responsabilidad_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_responsabilidad_id_responsabilidad_seq OWNED BY public.usuarios_responsabilidad.id_responsabilidad;


--
-- TOC entry 2814 (class 2604 OID 156427)
-- Name: componente_elemento_fundamental id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.componente_elemento_fundamental ALTER COLUMN id SET DEFAULT nextval('public.componente_elemento_fundamental_id_seq'::regclass);


--
-- TOC entry 2812 (class 2604 OID 82847)
-- Name: evaluacion id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluacion ALTER COLUMN id SET DEFAULT nextval('public.evaluacion_id_seq'::regclass);


--
-- TOC entry 2813 (class 2604 OID 82858)
-- Name: evaluacion_docentes id_evaluacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluacion_docentes ALTER COLUMN id_evaluacion SET DEFAULT nextval('public.evalucion_docentes_id_evaluacion_seq'::regclass);


--
-- TOC entry 2817 (class 2604 OID 197393)
-- Name: evidencias_evaluacion id_evaluacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evidencias_evaluacion ALTER COLUMN id_evaluacion SET DEFAULT nextval('public.evidencias_evaluacion_id_evaluacion_seq'::regclass);


--
-- TOC entry 2818 (class 2604 OID 221911)
-- Name: notificaciones id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notificaciones ALTER COLUMN id SET DEFAULT nextval('public.notificaciones_id_seq'::regclass);


--
-- TOC entry 2811 (class 2604 OID 82785)
-- Name: periodo_academico_usuarios id_usuarios; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.periodo_academico_usuarios ALTER COLUMN id_usuarios SET DEFAULT nextval('public.periodo_academico_usuarios_id_usuarios_seq'::regclass);


--
-- TOC entry 2815 (class 2604 OID 180942)
-- Name: responsabilidad id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.responsabilidad ALTER COLUMN id SET DEFAULT nextval('public.responsabilidad_id_seq'::regclass);


--
-- TOC entry 2810 (class 2604 OID 82753)
-- Name: titulos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.titulos ALTER COLUMN id SET DEFAULT nextval('public.titulos_id_seq'::regclass);


--
-- TOC entry 2809 (class 2604 OID 82641)
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- TOC entry 2816 (class 2604 OID 180958)
-- Name: usuarios_responsabilidad id_responsabilidad; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_responsabilidad ALTER COLUMN id_responsabilidad SET DEFAULT nextval('public.usuarios_responsabilidad_id_responsabilidad_seq'::regclass);


--
-- TOC entry 3028 (class 0 OID 82610)
-- Dependencies: 203
-- Data for Name: carreras; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carreras (id, nombre, id_facultad, numero_asig, total_horas_proyecto) FROM stdin;
%carreras%
\.


--
-- TOC entry 3046 (class 0 OID 82873)
-- Dependencies: 221
-- Data for Name: carreras_evidencias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carreras_evidencias (id_periodo_academico, id_evidencias, id_carrera, cod_evidencia, fecha_inicial, fecha_final, pdf, estado, fecha_registro, id_responsable, nombre_documento, valoracion, comentario, verificada) FROM stdin;
%carreras_evidencias%
\.


--
-- TOC entry 3039 (class 0 OID 82765)
-- Dependencies: 214
-- Data for Name: carreras_periodo_academico; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carreras_periodo_academico (id_carreras, id_periodo_academico) FROM stdin;
%carreras_periodo_academico%
\.


--
-- TOC entry 3050 (class 0 OID 156424)
-- Dependencies: 225
-- Data for Name: componente_elemento_fundamental; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.componente_elemento_fundamental (id, id_componente, id_elemento, descripcion) FROM stdin;
%componente_elemento_fundamental%
\.


--
-- TOC entry 3036 (class 0 OID 82690)
-- Dependencies: 211
-- Data for Name: criterios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.criterios (id, nombre) FROM stdin;
%criterios%
\.


--
-- TOC entry 3029 (class 0 OID 82623)
-- Dependencies: 204
-- Data for Name: docentes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.docentes (id, nombre, correo, clave, telefono, cambio_clave, apellido) FROM stdin;
%docentes%
\.


--
-- TOC entry 3047 (class 0 OID 90791)
-- Dependencies: 222
-- Data for Name: docentes_carreras; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.docentes_carreras (id_carreras, id_docentes) FROM stdin;
%docentes_carreras%
\.


--
-- TOC entry 3034 (class 0 OID 82674)
-- Dependencies: 209
-- Data for Name: elemento_fundamental; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.elemento_fundamental (id, descripcion, id_estandar) FROM stdin;
%elemento_fundamental%
\.


--
-- TOC entry 3035 (class 0 OID 82682)
-- Dependencies: 210
-- Data for Name: estandar; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.estandar (id, descripcion, id_criterio, nombre, tipo) FROM stdin;
%estandar%
\.


--
-- TOC entry 3043 (class 0 OID 82844)
-- Dependencies: 218
-- Data for Name: evaluacion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.evaluacion (id, nota, observacion) FROM stdin;
%evaluacion%
\.


--
-- TOC entry 3045 (class 0 OID 82855)
-- Dependencies: 220
-- Data for Name: evaluacion_docentes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.evaluacion_docentes (id_evaluacion, id_docente) FROM stdin;
%evaluacion_docentes%
\.


--
-- TOC entry 3051 (class 0 OID 156435)
-- Dependencies: 226
-- Data for Name: evidencia_componente_elemento_fundamental; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.evidencia_componente_elemento_fundamental (id_evidencias, id_componente) FROM stdin;
%evidencia_componente_elemento_fundamental%
\.


--
-- TOC entry 3033 (class 0 OID 82666)
-- Dependencies: 208
-- Data for Name: evidencias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.evidencias (id, nombre) FROM stdin;
%evidencias%
\.


--
-- TOC entry 3057 (class 0 OID 197390)
-- Dependencies: 232
-- Data for Name: evidencias_evaluacion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.evidencias_evaluacion (id_evidencia, id_carrera, id_periodo, id_evaluacion) FROM stdin;
%evidencias_evaluacion%
\.


--
-- TOC entry 3027 (class 0 OID 82602)
-- Dependencies: 202
-- Data for Name: facultad; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.facultad (id, nombre) FROM stdin;
%facultad%
\.


--
-- TOC entry 3059 (class 0 OID 221908)
-- Dependencies: 234
-- Data for Name: notificaciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notificaciones (id, remitente, receptor, mensaje, id_carrera, leido, mostrar, fecha) FROM stdin;
%notificaciones%
\.


--
-- TOC entry 3041 (class 0 OID 82782)
-- Dependencies: 216
-- Data for Name: periodo_academico_usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.periodo_academico_usuarios (id_periodo_academico, id_usuarios) FROM stdin;
\.


--
-- TOC entry 3030 (class 0 OID 82631)
-- Dependencies: 205
-- Data for Name: periodo_academicos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.periodo_academicos (id, fecha_inicial, fecha_final) FROM stdin;
%periodo_academicos%
\.


--
-- TOC entry 3053 (class 0 OID 180939)
-- Dependencies: 228
-- Data for Name: responsabilidad; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.responsabilidad (id, nombre, id_criterio) FROM stdin;
%responsabilidad%
\.


--
-- TOC entry 3038 (class 0 OID 82750)
-- Dependencies: 213
-- Data for Name: titulos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.titulos (id, nombre, id_docente) FROM stdin;
%titulos%
\.


--
-- TOC entry 3032 (class 0 OID 82638)
-- Dependencies: 207
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios (id, descripcion, permisos) FROM stdin;
%usuarios%
\.


--
-- TOC entry 3048 (class 0 OID 107211)
-- Dependencies: 223
-- Data for Name: usuarios_docente; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios_docente (id_usuarios, id_docentes, id_carrera, fecha_inicial, fecha_final, estado, carrera) FROM stdin;
%usuarios_docente%
\.


--
-- TOC entry 3055 (class 0 OID 180955)
-- Dependencies: 230
-- Data for Name: usuarios_responsabilidad; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios_responsabilidad (id_usuarios, id_responsabilidad, id_docentes, id_carrera, id_periodo_academico, fecha_inicial, fecha_final) FROM stdin;
%usuarios_responsabilidad%
\.


--
-- TOC entry 3075 (class 0 OID 0)
-- Dependencies: 224
-- Name: componente_elemento_fundamental_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.componente_elemento_fundamental_id_seq', 2597, true);


--
-- TOC entry 3076 (class 0 OID 0)
-- Dependencies: 217
-- Name: evaluacion_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.evaluacion_id_seq', 19, true);


--
-- TOC entry 3077 (class 0 OID 0)
-- Dependencies: 219
-- Name: evalucion_docentes_id_evaluacion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.evalucion_docentes_id_evaluacion_seq', 1, false);


--
-- TOC entry 3078 (class 0 OID 0)
-- Dependencies: 231
-- Name: evidencias_evaluacion_id_evaluacion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.evidencias_evaluacion_id_evaluacion_seq', 1, false);


--
-- TOC entry 3079 (class 0 OID 0)
-- Dependencies: 233
-- Name: notificaciones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notificaciones_id_seq', 33, true);


--
-- TOC entry 3080 (class 0 OID 0)
-- Dependencies: 215
-- Name: periodo_academico_usuarios_id_usuarios_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.periodo_academico_usuarios_id_usuarios_seq', 1, false);


--
-- TOC entry 3081 (class 0 OID 0)
-- Dependencies: 227
-- Name: responsabilidad_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.responsabilidad_id_seq', 42, true);


--
-- TOC entry 3082 (class 0 OID 0)
-- Dependencies: 212
-- Name: titulos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.titulos_id_seq', 1, false);


--
-- TOC entry 3083 (class 0 OID 0)
-- Dependencies: 206
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 5, true);


--
-- TOC entry 3084 (class 0 OID 0)
-- Dependencies: 229
-- Name: usuarios_responsabilidad_id_responsabilidad_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuarios_responsabilidad_id_responsabilidad_seq', 1, false);


--
-- TOC entry 2848 (class 2606 OID 156454)
-- Name: carreras_evidencias carreras_evidencias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT carreras_evidencias_pkey PRIMARY KEY (id_carrera, cod_evidencia, id_evidencias, id_periodo_academico);


--
-- TOC entry 2840 (class 2606 OID 82769)
-- Name: carreras_periodo_academico carreras_periodo_academico_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_periodo_academico
    ADD CONSTRAINT carreras_periodo_academico_pkey PRIMARY KEY (id_carreras, id_periodo_academico);


--
-- TOC entry 2822 (class 2606 OID 82617)
-- Name: carreras carreras_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras
    ADD CONSTRAINT carreras_pkey PRIMARY KEY (id);


--
-- TOC entry 2855 (class 2606 OID 156432)
-- Name: componente_elemento_fundamental componente_elemento_fundamental_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.componente_elemento_fundamental
    ADD CONSTRAINT componente_elemento_fundamental_pkey PRIMARY KEY (id, id_componente, id_elemento);


--
-- TOC entry 2836 (class 2606 OID 82694)
-- Name: criterios criterios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.criterios
    ADD CONSTRAINT criterios_pkey PRIMARY KEY (id);


--
-- TOC entry 2851 (class 2606 OID 90795)
-- Name: docentes_carreras docentes_carreras_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.docentes_carreras
    ADD CONSTRAINT docentes_carreras_pkey PRIMARY KEY (id_carreras, id_docentes);


--
-- TOC entry 2824 (class 2606 OID 82630)
-- Name: docentes docentes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.docentes
    ADD CONSTRAINT docentes_pkey PRIMARY KEY (id);


--
-- TOC entry 2832 (class 2606 OID 82681)
-- Name: elemento_fundamental elemento_fundamental_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.elemento_fundamental
    ADD CONSTRAINT elemento_fundamental_pkey PRIMARY KEY (id);


--
-- TOC entry 2834 (class 2606 OID 82689)
-- Name: estandar estandar_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estandar
    ADD CONSTRAINT estandar_pkey PRIMARY KEY (id);


--
-- TOC entry 2844 (class 2606 OID 82852)
-- Name: evaluacion evaluacion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluacion
    ADD CONSTRAINT evaluacion_pkey PRIMARY KEY (id);


--
-- TOC entry 2846 (class 2606 OID 82860)
-- Name: evaluacion_docentes evalucion_docentes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluacion_docentes
    ADD CONSTRAINT evalucion_docentes_pkey PRIMARY KEY (id_evaluacion, id_docente);


--
-- TOC entry 2859 (class 2606 OID 156442)
-- Name: evidencia_componente_elemento_fundamental evidencia_componente_elemento_fundamental_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evidencia_componente_elemento_fundamental
    ADD CONSTRAINT evidencia_componente_elemento_fundamental_pkey PRIMARY KEY (id_evidencias, id_componente);


--
-- TOC entry 2865 (class 2606 OID 197398)
-- Name: evidencias_evaluacion evidencias_evaluacion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evidencias_evaluacion
    ADD CONSTRAINT evidencias_evaluacion_pkey PRIMARY KEY (id_evidencia, id_carrera, id_periodo);


--
-- TOC entry 2830 (class 2606 OID 82673)
-- Name: evidencias evidencias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evidencias
    ADD CONSTRAINT evidencias_pkey PRIMARY KEY (id);


--
-- TOC entry 2820 (class 2606 OID 82609)
-- Name: facultad facultad_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.facultad
    ADD CONSTRAINT facultad_pkey PRIMARY KEY (id);


--
-- TOC entry 2868 (class 2606 OID 221916)
-- Name: notificaciones notificaciones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notificaciones
    ADD CONSTRAINT notificaciones_pkey PRIMARY KEY (id);


--
-- TOC entry 2826 (class 2606 OID 82635)
-- Name: periodo_academicos periodo_academico_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.periodo_academicos
    ADD CONSTRAINT periodo_academico_pkey PRIMARY KEY (id);


--
-- TOC entry 2842 (class 2606 OID 82787)
-- Name: periodo_academico_usuarios periodo_academico_usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.periodo_academico_usuarios
    ADD CONSTRAINT periodo_academico_usuarios_pkey PRIMARY KEY (id_periodo_academico, id_usuarios);


--
-- TOC entry 2861 (class 2606 OID 180947)
-- Name: responsabilidad responsabilidad_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.responsabilidad
    ADD CONSTRAINT responsabilidad_pkey PRIMARY KEY (id);


--
-- TOC entry 2838 (class 2606 OID 82758)
-- Name: titulos titulos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.titulos
    ADD CONSTRAINT titulos_pkey PRIMARY KEY (id);


--
-- TOC entry 2857 (class 2606 OID 156434)
-- Name: componente_elemento_fundamental uk_id; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.componente_elemento_fundamental
    ADD CONSTRAINT uk_id UNIQUE (id) INCLUDE (id);


--
-- TOC entry 2853 (class 2606 OID 107215)
-- Name: usuarios_docente usuarios_docente_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_docente
    ADD CONSTRAINT usuarios_docente_pkey PRIMARY KEY (id_usuarios, id_docentes, id_carrera);


--
-- TOC entry 2828 (class 2606 OID 82646)
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- TOC entry 2863 (class 2606 OID 180960)
-- Name: usuarios_responsabilidad usuarios_responsabilidad_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT usuarios_responsabilidad_pkey PRIMARY KEY (id_usuarios, id_responsabilidad, id_docentes, id_carrera, id_periodo_academico);


--
-- TOC entry 2866 (class 1259 OID 221919)
-- Name: id_carrera_1671581287948_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX id_carrera_1671581287948_index ON public.notificaciones USING btree (id_carrera);


--
-- TOC entry 2849 (class 1259 OID 156455)
-- Name: idxtbcod_evidencia_1668524951416_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idxtbcod_evidencia_1668524951416_index ON public.carreras_evidencias USING btree (cod_evidencia);


--
-- TOC entry 2869 (class 1259 OID 221918)
-- Name: receptor_1671581287948_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX receptor_1671581287948_index ON public.notificaciones USING btree (receptor);


--
-- TOC entry 2870 (class 1259 OID 221917)
-- Name: remitente_1671581287948_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX remitente_1671581287948_index ON public.notificaciones USING btree (remitente);


--
-- TOC entry 2888 (class 2606 OID 107226)
-- Name: usuarios_docente fk_id_carrera; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_docente
    ADD CONSTRAINT fk_id_carrera FOREIGN KEY (id_carrera) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2883 (class 2606 OID 148178)
-- Name: carreras_evidencias fk_id_carrera; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT fk_id_carrera FOREIGN KEY (id_carrera) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- TOC entry 2898 (class 2606 OID 197404)
-- Name: evidencias_evaluacion fk_id_carrera; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evidencias_evaluacion
    ADD CONSTRAINT fk_id_carrera FOREIGN KEY (id_carrera) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2875 (class 2606 OID 82770)
-- Name: carreras_periodo_academico fk_id_carreras; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_periodo_academico
    ADD CONSTRAINT fk_id_carreras FOREIGN KEY (id_carreras) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2884 (class 2606 OID 90796)
-- Name: docentes_carreras fk_id_carreras; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.docentes_carreras
    ADD CONSTRAINT fk_id_carreras FOREIGN KEY (id_carreras) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2895 (class 2606 OID 180976)
-- Name: usuarios_responsabilidad fk_id_carreras; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT fk_id_carreras FOREIGN KEY (id_carrera) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- TOC entry 2890 (class 2606 OID 156448)
-- Name: evidencia_componente_elemento_fundamental fk_id_componente; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evidencia_componente_elemento_fundamental
    ADD CONSTRAINT fk_id_componente FOREIGN KEY (id_componente) REFERENCES public.componente_elemento_fundamental(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2891 (class 2606 OID 180948)
-- Name: responsabilidad fk_id_criterio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.responsabilidad
    ADD CONSTRAINT fk_id_criterio FOREIGN KEY (id_criterio) REFERENCES public.criterios(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2873 (class 2606 OID 82700)
-- Name: estandar fk_id_criterios; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estandar
    ADD CONSTRAINT fk_id_criterios FOREIGN KEY (id_criterio) REFERENCES public.criterios(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- TOC entry 2885 (class 2606 OID 90801)
-- Name: docentes_carreras fk_id_docentes; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.docentes_carreras
    ADD CONSTRAINT fk_id_docentes FOREIGN KEY (id_docentes) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2887 (class 2606 OID 107221)
-- Name: usuarios_docente fk_id_docentes; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_docente
    ADD CONSTRAINT fk_id_docentes FOREIGN KEY (id_docentes) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2894 (class 2606 OID 180971)
-- Name: usuarios_responsabilidad fk_id_docentes; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT fk_id_docentes FOREIGN KEY (id_docentes) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- TOC entry 2872 (class 2606 OID 82695)
-- Name: elemento_fundamental fk_id_estandar; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.elemento_fundamental
    ADD CONSTRAINT fk_id_estandar FOREIGN KEY (id_estandar) REFERENCES public.estandar(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- TOC entry 2900 (class 2606 OID 197414)
-- Name: evidencias_evaluacion fk_id_evaluacion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evidencias_evaluacion
    ADD CONSTRAINT fk_id_evaluacion FOREIGN KEY (id_evaluacion) REFERENCES public.evaluacion(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2897 (class 2606 OID 197399)
-- Name: evidencias_evaluacion fk_id_evidencia; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evidencias_evaluacion
    ADD CONSTRAINT fk_id_evidencia FOREIGN KEY (id_evidencia) REFERENCES public.evidencias(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2881 (class 2606 OID 82889)
-- Name: carreras_evidencias fk_id_evidencias; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT fk_id_evidencias FOREIGN KEY (id_evidencias) REFERENCES public.evidencias(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2889 (class 2606 OID 156443)
-- Name: evidencia_componente_elemento_fundamental fk_id_evidencias; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evidencia_componente_elemento_fundamental
    ADD CONSTRAINT fk_id_evidencias FOREIGN KEY (id_evidencias) REFERENCES public.evidencias(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2871 (class 2606 OID 123593)
-- Name: carreras fk_id_facultad; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras
    ADD CONSTRAINT fk_id_facultad FOREIGN KEY (id_facultad) REFERENCES public.facultad(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- TOC entry 2899 (class 2606 OID 197409)
-- Name: evidencias_evaluacion fk_id_periodo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evidencias_evaluacion
    ADD CONSTRAINT fk_id_periodo FOREIGN KEY (id_periodo) REFERENCES public.periodo_academicos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2876 (class 2606 OID 82775)
-- Name: carreras_periodo_academico fk_id_periodo_academico; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_periodo_academico
    ADD CONSTRAINT fk_id_periodo_academico FOREIGN KEY (id_periodo_academico) REFERENCES public.periodo_academicos(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2882 (class 2606 OID 148169)
-- Name: carreras_evidencias fk_id_periodo_academico; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT fk_id_periodo_academico FOREIGN KEY (id_periodo_academico) REFERENCES public.periodo_academicos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2896 (class 2606 OID 180981)
-- Name: usuarios_responsabilidad fk_id_periodo_academico; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT fk_id_periodo_academico FOREIGN KEY (id_periodo_academico) REFERENCES public.periodo_academicos(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- TOC entry 2893 (class 2606 OID 180966)
-- Name: usuarios_responsabilidad fk_id_responsabilidad; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT fk_id_responsabilidad FOREIGN KEY (id_responsabilidad) REFERENCES public.responsabilidad(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- TOC entry 2874 (class 2606 OID 82759)
-- Name: titulos fk_id_usuario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.titulos
    ADD CONSTRAINT fk_id_usuario FOREIGN KEY (id_docente) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2878 (class 2606 OID 82793)
-- Name: periodo_academico_usuarios fk_id_usuarios; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.periodo_academico_usuarios
    ADD CONSTRAINT fk_id_usuarios FOREIGN KEY (id_usuarios) REFERENCES public.usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2886 (class 2606 OID 107216)
-- Name: usuarios_docente fk_id_usuarios; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_docente
    ADD CONSTRAINT fk_id_usuarios FOREIGN KEY (id_usuarios) REFERENCES public.usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2892 (class 2606 OID 180961)
-- Name: usuarios_responsabilidad fk_id_usuarios; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT fk_id_usuarios FOREIGN KEY (id_usuarios) REFERENCES public.usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- TOC entry 2877 (class 2606 OID 82788)
-- Name: periodo_academico_usuarios fk_periodo_academico; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.periodo_academico_usuarios
    ADD CONSTRAINT fk_periodo_academico FOREIGN KEY (id_periodo_academico) REFERENCES public.periodo_academicos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2880 (class 2606 OID 82866)
-- Name: evaluacion_docentes id_docente; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluacion_docentes
    ADD CONSTRAINT id_docente FOREIGN KEY (id_docente) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2879 (class 2606 OID 82861)
-- Name: evaluacion_docentes id_evaluacion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluacion_docentes
    ADD CONSTRAINT id_evaluacion FOREIGN KEY (id_evaluacion) REFERENCES public.evaluacion(id) ON UPDATE CASCADE ON DELETE RESTRICT;


-- Completed on 2023-01-25 14:43:19

--
-- PostgreSQL database dump complete
--

