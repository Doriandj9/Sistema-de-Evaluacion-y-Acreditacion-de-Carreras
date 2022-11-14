--
-- PostgreSQL database dump
--

-- Dumped from database version 12.1
-- Dumped by pg_dump version 12.1

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
-- Name: carreras_evidencias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carreras_evidencias (
    id_periodo_academico character(10) NOT NULL,
    id_evidencias text NOT NULL,
    id_carrera character(8) NOT NULL,
    cod_evidencia character(15) NOT NULL
);


ALTER TABLE public.carreras_evidencias OWNER TO postgres;

--
-- Name: carreras_periodo_academico; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carreras_periodo_academico (
    id_carreras character(8) NOT NULL,
    id_periodo_academico character(10) NOT NULL
);


ALTER TABLE public.carreras_periodo_academico OWNER TO postgres;

--
-- Name: criterios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.criterios (
    id character(15) NOT NULL,
    nombre character(120) NOT NULL
);


ALTER TABLE public.criterios OWNER TO postgres;

--
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
-- Name: docentes_carreras; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.docentes_carreras (
    id_carreras character(8) NOT NULL,
    id_docentes character(10) NOT NULL
);


ALTER TABLE public.docentes_carreras OWNER TO postgres;

--
-- Name: elemento_fundamental; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.elemento_fundamental (
    id character(15) NOT NULL,
    descripcion text NOT NULL,
    id_estandar character(15) NOT NULL
);


ALTER TABLE public.elemento_fundamental OWNER TO postgres;

--
-- Name: estandar; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.estandar (
    id character(15) NOT NULL,
    descripcion text NOT NULL,
    id_criterio character(15) NOT NULL
);


ALTER TABLE public.estandar OWNER TO postgres;

--
-- Name: evaluacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.evaluacion (
    id bigint NOT NULL,
    nota text NOT NULL
);


ALTER TABLE public.evaluacion OWNER TO postgres;

--
-- Name: evaluacion_docentes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.evaluacion_docentes (
    id_evaluacion bigint NOT NULL,
    id_docente character(10) NOT NULL
);


ALTER TABLE public.evaluacion_docentes OWNER TO postgres;

--
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
-- Name: evaluacion_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.evaluacion_id_seq OWNED BY public.evaluacion.id;


--
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
-- Name: evalucion_docentes_id_evaluacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.evalucion_docentes_id_evaluacion_seq OWNED BY public.evaluacion_docentes.id_evaluacion;


--
-- Name: evidencias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.evidencias (
    id text NOT NULL,
    nombre text NOT NULL
);


ALTER TABLE public.evidencias OWNER TO postgres;

--
-- Name: facultad; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.facultad (
    id character(8) NOT NULL,
    nombre text NOT NULL
);


ALTER TABLE public.facultad OWNER TO postgres;

--
-- Name: historial_usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.historial_usuarios (
    id bigint NOT NULL,
    fecha_inicial date NOT NULL,
    fecha_final date NOT NULL,
    id_usuarios integer NOT NULL,
    responsabilidad text NOT NULL
);


ALTER TABLE public.historial_usuarios OWNER TO postgres;

--
-- Name: historial_usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.historial_usuarios_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.historial_usuarios_id_seq OWNER TO postgres;

--
-- Name: historial_usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.historial_usuarios_id_seq OWNED BY public.historial_usuarios.id;


--
-- Name: historial_usuarios_id_usuarios_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.historial_usuarios_id_usuarios_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.historial_usuarios_id_usuarios_seq OWNER TO postgres;

--
-- Name: historial_usuarios_id_usuarios_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.historial_usuarios_id_usuarios_seq OWNED BY public.historial_usuarios.id_usuarios;


--
-- Name: periodo_academico_usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.periodo_academico_usuarios (
    id_periodo_academico character(10) NOT NULL,
    id_usuarios integer NOT NULL
);


ALTER TABLE public.periodo_academico_usuarios OWNER TO postgres;

--
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
-- Name: periodo_academico_usuarios_id_usuarios_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.periodo_academico_usuarios_id_usuarios_seq OWNED BY public.periodo_academico_usuarios.id_usuarios;


--
-- Name: periodo_academicos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.periodo_academicos (
    id character(10) NOT NULL,
    fecha_inicial date NOT NULL,
    fecha_final date NOT NULL
);


ALTER TABLE public.periodo_academicos OWNER TO postgres;

--
-- Name: prueba; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.prueba (
    id character(3) NOT NULL,
    nombre character(25),
    apellido character(25),
    direcion character(40)
);


ALTER TABLE public.prueba OWNER TO postgres;

--
-- Name: responsabilidad; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.responsabilidad (
    id bigint NOT NULL,
    nombre text NOT NULL,
    id_evidencias text NOT NULL
);


ALTER TABLE public.responsabilidad OWNER TO postgres;

--
-- Name: responsabilidad_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.responsabilidad_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.responsabilidad_id_seq OWNER TO postgres;

--
-- Name: responsabilidad_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.responsabilidad_id_seq OWNED BY public.responsabilidad.id;


--
-- Name: titulos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.titulos (
    id bigint NOT NULL,
    nombre text NOT NULL,
    id_docente character(10) NOT NULL
);


ALTER TABLE public.titulos OWNER TO postgres;

--
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
-- Name: titulos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.titulos_id_seq OWNED BY public.titulos.id;


--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    decripcion text NOT NULL,
    permisos bigint
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- Name: usuarios_docente; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios_docente (
    id_usuarios integer NOT NULL,
    id_docentes character(10) NOT NULL,
    id_carrera character(8) NOT NULL,
    fecha_inicial date NOT NULL,
    fecha_final date NOT NULL,
    estado character(10) NOT NULL
);


ALTER TABLE public.usuarios_docente OWNER TO postgres;

--
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
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- Name: usuarios_responsabilidad; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios_responsabilidad (
    id_usuarios integer NOT NULL,
    id_responsabilidad bigint NOT NULL,
    id_docentes character(10) NOT NULL
);


ALTER TABLE public.usuarios_responsabilidad OWNER TO postgres;

--
-- Name: usuarios_responsabilidad_id_responsabilidad_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_responsabilidad_id_responsabilidad_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuarios_responsabilidad_id_responsabilidad_seq OWNER TO postgres;

--
-- Name: usuarios_responsabilidad_id_responsabilidad_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_responsabilidad_id_responsabilidad_seq OWNED BY public.usuarios_responsabilidad.id_responsabilidad;


--
-- Name: usuarios_responsabilidad_id_usuarios_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_responsabilidad_id_usuarios_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuarios_responsabilidad_id_usuarios_seq OWNER TO postgres;

--
-- Name: usuarios_responsabilidad_id_usuarios_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_responsabilidad_id_usuarios_seq OWNED BY public.usuarios_responsabilidad.id_usuarios;


--
-- Name: evaluacion id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluacion ALTER COLUMN id SET DEFAULT nextval('public.evaluacion_id_seq'::regclass);


--
-- Name: evaluacion_docentes id_evaluacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluacion_docentes ALTER COLUMN id_evaluacion SET DEFAULT nextval('public.evalucion_docentes_id_evaluacion_seq'::regclass);


--
-- Name: historial_usuarios id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.historial_usuarios ALTER COLUMN id SET DEFAULT nextval('public.historial_usuarios_id_seq'::regclass);


--
-- Name: historial_usuarios id_usuarios; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.historial_usuarios ALTER COLUMN id_usuarios SET DEFAULT nextval('public.historial_usuarios_id_usuarios_seq'::regclass);


--
-- Name: periodo_academico_usuarios id_usuarios; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.periodo_academico_usuarios ALTER COLUMN id_usuarios SET DEFAULT nextval('public.periodo_academico_usuarios_id_usuarios_seq'::regclass);


--
-- Name: responsabilidad id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.responsabilidad ALTER COLUMN id SET DEFAULT nextval('public.responsabilidad_id_seq'::regclass);


--
-- Name: titulos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.titulos ALTER COLUMN id SET DEFAULT nextval('public.titulos_id_seq'::regclass);


--
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- Name: usuarios_responsabilidad id_usuarios; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_responsabilidad ALTER COLUMN id_usuarios SET DEFAULT nextval('public.usuarios_responsabilidad_id_usuarios_seq'::regclass);


--
-- Name: usuarios_responsabilidad id_responsabilidad; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_responsabilidad ALTER COLUMN id_responsabilidad SET DEFAULT nextval('public.usuarios_responsabilidad_id_responsabilidad_seq'::regclass);


--
-- Data for Name: carreras; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carreras (id, nombre, id_facultad, numero_asig, total_horas_proyecto) FROM stdin;
MERC    	Mercadotecnia	1-AD    	15	120
BET     	Veterinaria	3-AGR   	14	158
TICS    	TICS	0-TICS  	1	1
SOFT    	Software	1-AD    	45	148
ENF     	Enfermería	3-AGR   	45	280
AGRO    	Agronomia	3-AGR   	25	158
DEREC   	Derecho	2-DER   	20	120
ADEM    	Administración de Empresas	1-AD    	24	145
\.


--
-- Data for Name: carreras_evidencias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carreras_evidencias (id_periodo_academico, id_evidencias, id_carrera, cod_evidencia) FROM stdin;
\.


--
-- Data for Name: carreras_periodo_academico; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.carreras_periodo_academico (id_carreras, id_periodo_academico) FROM stdin;
SOFT    	2022-2022 
AGRO    	2022-2022 
MERC    	2022-2022 
ENF     	2022-2022 
DEREC   	2022-2022 
ADEM    	2022-2022 
MERC    	2021-2022 
BET     	2022-2022 
AGRO    	2021-2022 
ADEM    	2021-2022 
BET     	2021-2022 
SOFT    	2021-2022 
ENF     	2021-2022 
DEREC   	2021-2022 
MERC    	2021-2021 
BET     	2021-2021 
SOFT    	2021-2021 
ENF     	2021-2021 
AGRO    	2021-2021 
DEREC   	2021-2021 
ADEM    	2021-2021 
TICS    	2021-2021 
\.


--
-- Data for Name: criterios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.criterios (id, nombre) FROM stdin;
1              	Pertinencia                                                                                                             
\.


--
-- Data for Name: docentes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.docentes (id, nombre, correo, clave, telefono, cambio_clave, apellido) FROM stdin;
0250186663	Luis Miguel	lcadena@ueb.edu.ec	$2y$10$gmEe/2bzWR1UpmJmgX.qUuGbPZXYfjPMP4TYlkjrGnlCwljhxA58O                                                                                                                                                                                                                                                                                                                                                                                                                                                        	0989960587	f	Coloma Cadena
0258889746	Jose Mario	apaez@ueb.edu.ec	$2y$10$v7kb5NzINIWyOJqrHe91petPfhB980DbdExhY77y1mSp.y6jr9Nfq                                                                                                                                                                                                                                                                                                                                                                                                                                                        	\N	t	Aldaz Paez
0250186666	Darlo Jose	dcarpaz@ueb.edu.ec	$2y$10$NU8/IjNGHdIsk3sjaqyj7edf/eD.Qq1yNAQ3Vk3qeJ3G3xT1tLKMi                                                                                                                                                                                                                                                                                                                                                                                                                                                        	\N	f	Fernandez Carapaz
0250186665	Dorian	dorian@ueb.edu.ec	$2y$10$yTjEIYTiSVcVO1.wcPs0b.iDwk6SxnNyZIM20slSm2V.QQjMz6eDu                                                                                                                                                                                                                                                                                                                                                                                                                                                        	0989960587	f	Armijos
0255879946	Pedro Jose	mpalacios@ueb.edu.ec	$2y$10$pDOhM2n7aOhqMSHf7VXU1O5YgTYWWAbFMYqIe.k77ZYSIdf6nWh96                                                                                                                                                                                                                                                                                                                                                                                                                                                        	0989960587	f	Mariño Palacios
1233246665	Jhon Jose	jartega@ueb.edu.ec	$2y$10$ypUn9jlLbguGCaYeGp0ACu7SHQpXlQcn0kQzI02uFBqlgxTsN2J7S                                                                                                                                                                                                                                                                                                                                                                                                                                                        	          	t	Artega Perez
0123456789	Dario	dorian@ueb.edu.ec	$2y$10$EMnPqXGi1sLrc/75Fkmbf.BpRF0WAIsiZiWKpB1DFAyAn2RSy6VqG                                                                                                                                                                                                                                                                                                                                                                                                                                                        	0984456781	f	Farias
1234567890	Mario Pedro	mpedro@ueb.edu.ec	$2y$10$b92Aw4W76nkFH9MOfsKnzOleGYvhB6aKbbX2/X3IrHJPkOpEQwGde                                                                                                                                                                                                                                                                                                                                                                                                                                                        	0969395344	f	Marquez Velos
0250186664	Dario Jose	dcamacho@ueb.edu.ec	$2y$10$GXTSW7wsGkIwS/pO2AWyLeAPSPcnajLkQ7WOjplFYhxOhfoxpPKgy                                                                                                                                                                                                                                                                                                                                                                                                                                                        	\N	t	Barragan Camacho
0202468831	Nataly	nfernandez@mailes.ueb.edu.ec	$2y$10$7pla3rtouIVNIWAe0hUfbOvmLuTh8VyeZHcAknAjnsX3tBNW6cN0m                                                                                                                                                                                                                                                                                                                                                                                                                                                        	\N	f	Fernandez
0250186661	Josue Dario	darmijos@mailes.ueb.edu.ec	$2y$10$VXalzcw9XR2ivyOUdQ24n.FihI1OztB92EhvBjbTmzhBTeenIIjPu                                                                                                                                                                                                                                                                                                                                                                                                                                                        	\N	t	Armijos Gadvay
0250159996	Mario Sleyter	darmijos@mailes.ueb.edu.ec	$2y$10$eX5sUTDnsANY73PpE.y/AO.NOrRxjpHMiZxM.TfNQTr7yoA82vVDS                                                                                                                                                                                                                                                                                                                                                                                                                                                        	\N	t	Lopez Cabezas
1545645   			$2y$10$fO0OyTJLU/MaoWLrDTIsJesum0F7mledBMu23shWr0cobQadaTHqC                                                                                                                                                                                                                                                                                                                                                                                                                                                        	\N	t	
0255447568	Darwin Maicol	dtrujillo@ueb.edu.ec	$2y$10$/7884C6BObPIJ/q.OphW8uoLg29kBxVEf/6D7i86ZPZpq.D63HK9m                                                                                                                                                                                                                                                                                                                                                                                                                                                        	098995487 	t	Paredes Trujillo
\.


--
-- Data for Name: docentes_carreras; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.docentes_carreras (id_carreras, id_docentes) FROM stdin;
AGRO    	1234567890
MERC    	0250186664
ENF     	0250186663
MERC    	0250186666
SOFT    	0258889746
DEREC   	0255879946
SOFT    	0202468831
ENF     	0250186661
ENF     	0250159996
ENF     	1545645   
\.


--
-- Data for Name: elemento_fundamental; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.elemento_fundamental (id, descripcion, id_estandar) FROM stdin;
\.


--
-- Data for Name: estandar; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.estandar (id, descripcion, id_criterio) FROM stdin;
\.


--
-- Data for Name: evaluacion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.evaluacion (id, nota) FROM stdin;
\.


--
-- Data for Name: evaluacion_docentes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.evaluacion_docentes (id_evaluacion, id_docente) FROM stdin;
\.


--
-- Data for Name: evidencias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.evidencias (id, nombre) FROM stdin;
\.


--
-- Data for Name: facultad; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.facultad (id, nombre) FROM stdin;
1-AD    	Ciencias Administrativas Gestión Empresarial e Informática
2-DER   	Derecho Y Jurisprudencia
4-SAL   	Salud y Obstetricia
0-TICS  	TICS
3-AGR   	Ciencias de Agronomías
\.


--
-- Data for Name: historial_usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.historial_usuarios (id, fecha_inicial, fecha_final, id_usuarios, responsabilidad) FROM stdin;
\.


--
-- Data for Name: periodo_academico_usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.periodo_academico_usuarios (id_periodo_academico, id_usuarios) FROM stdin;
\.


--
-- Data for Name: periodo_academicos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.periodo_academicos (id, fecha_inicial, fecha_final) FROM stdin;
2022-2022 	2022-04-13	2022-08-30
2021-2022 	2021-05-07	2022-02-19
2021-2021 	2021-04-20	2021-08-21
\.


--
-- Data for Name: prueba; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.prueba (id, nombre, apellido, direcion) FROM stdin;
\.


--
-- Data for Name: responsabilidad; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.responsabilidad (id, nombre, id_evidencias) FROM stdin;
\.


--
-- Data for Name: titulos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.titulos (id, nombre, id_docente) FROM stdin;
\.


--
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios (id, decripcion, permisos) FROM stdin;
16	Administrador	16
1	Docente	1
4	Coordinador	4
8	Evaluador	8
2	Director Planeamiento	2
\.


--
-- Data for Name: usuarios_docente; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios_docente (id_usuarios, id_docentes, id_carrera, fecha_inicial, fecha_final, estado) FROM stdin;
4	0250186664	MERC    	2022-10-03	2052-10-03	activo    
4	0202468831	SOFT    	2022-10-03	2052-10-03	activo    
4	0250186663	ENF     	2022-11-03	2022-11-18	activo    
4	1234567890	AGRO    	2022-10-21	2022-10-29	inactivo  
4	0255879946	DEREC   	2022-11-02	2022-12-23	activo    
1	0250186661	ENF     	2022-11-12	2022-11-17	activo    
1	0250159996	ENF     	2022-11-12	2022-11-19	activo    
2	0255447568	TICS    	2022-11-13	2022-12-09	activo    
16	0250186665	SOFT    	2022-10-03	2025-05-06	activo    
4	0258889746	SOFT    	2022-11-20	2022-11-23	activo    
4	0250186666	MERC    	2022-11-13	2022-11-30	inactivo  
2	1233246665	TICS    	2022-11-16	2022-11-26	activo    
\.


--
-- Data for Name: usuarios_responsabilidad; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios_responsabilidad (id_usuarios, id_responsabilidad, id_docentes) FROM stdin;
\.


--
-- Name: evaluacion_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.evaluacion_id_seq', 1, false);


--
-- Name: evalucion_docentes_id_evaluacion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.evalucion_docentes_id_evaluacion_seq', 1, false);


--
-- Name: historial_usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.historial_usuarios_id_seq', 1, false);


--
-- Name: historial_usuarios_id_usuarios_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.historial_usuarios_id_usuarios_seq', 1, false);


--
-- Name: periodo_academico_usuarios_id_usuarios_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.periodo_academico_usuarios_id_usuarios_seq', 1, false);


--
-- Name: responsabilidad_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.responsabilidad_id_seq', 1, false);


--
-- Name: titulos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.titulos_id_seq', 1, false);


--
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 4, true);


--
-- Name: usuarios_responsabilidad_id_responsabilidad_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuarios_responsabilidad_id_responsabilidad_seq', 1, false);


--
-- Name: usuarios_responsabilidad_id_usuarios_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuarios_responsabilidad_id_usuarios_seq', 1, false);


--
-- Name: carreras_evidencias carreras_evidencias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT carreras_evidencias_pkey PRIMARY KEY (id_carrera, cod_evidencia, id_evidencias, id_periodo_academico);


--
-- Name: carreras_periodo_academico carreras_periodo_academico_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_periodo_academico
    ADD CONSTRAINT carreras_periodo_academico_pkey PRIMARY KEY (id_carreras, id_periodo_academico);


--
-- Name: carreras carreras_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras
    ADD CONSTRAINT carreras_pkey PRIMARY KEY (id);


--
-- Name: criterios criterios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.criterios
    ADD CONSTRAINT criterios_pkey PRIMARY KEY (id);


--
-- Name: docentes_carreras docentes_carreras_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.docentes_carreras
    ADD CONSTRAINT docentes_carreras_pkey PRIMARY KEY (id_carreras, id_docentes);


--
-- Name: docentes docentes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.docentes
    ADD CONSTRAINT docentes_pkey PRIMARY KEY (id);


--
-- Name: elemento_fundamental elemento_fundamental_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.elemento_fundamental
    ADD CONSTRAINT elemento_fundamental_pkey PRIMARY KEY (id);


--
-- Name: estandar estandar_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estandar
    ADD CONSTRAINT estandar_pkey PRIMARY KEY (id);


--
-- Name: evaluacion evaluacion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluacion
    ADD CONSTRAINT evaluacion_pkey PRIMARY KEY (id);


--
-- Name: evaluacion_docentes evalucion_docentes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluacion_docentes
    ADD CONSTRAINT evalucion_docentes_pkey PRIMARY KEY (id_evaluacion, id_docente);


--
-- Name: evidencias evidencias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evidencias
    ADD CONSTRAINT evidencias_pkey PRIMARY KEY (id);


--
-- Name: facultad facultad_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.facultad
    ADD CONSTRAINT facultad_pkey PRIMARY KEY (id);


--
-- Name: historial_usuarios historial_usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.historial_usuarios
    ADD CONSTRAINT historial_usuarios_pkey PRIMARY KEY (id);


--
-- Name: periodo_academicos periodo_academico_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.periodo_academicos
    ADD CONSTRAINT periodo_academico_pkey PRIMARY KEY (id);


--
-- Name: periodo_academico_usuarios periodo_academico_usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.periodo_academico_usuarios
    ADD CONSTRAINT periodo_academico_usuarios_pkey PRIMARY KEY (id_periodo_academico, id_usuarios);


--
-- Name: prueba prueba_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.prueba
    ADD CONSTRAINT prueba_pkey PRIMARY KEY (id);


--
-- Name: responsabilidad responsabilidad_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.responsabilidad
    ADD CONSTRAINT responsabilidad_pkey PRIMARY KEY (id);


--
-- Name: titulos titulos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.titulos
    ADD CONSTRAINT titulos_pkey PRIMARY KEY (id);


--
-- Name: carreras_evidencias u_cod_evidencia; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT u_cod_evidencia UNIQUE (cod_evidencia) INCLUDE (cod_evidencia);


--
-- Name: usuarios_docente usuarios_docente_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_docente
    ADD CONSTRAINT usuarios_docente_pkey PRIMARY KEY (id_usuarios, id_docentes, id_carrera);


--
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- Name: usuarios_responsabilidad usuarios_responsabilidad_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT usuarios_responsabilidad_pkey PRIMARY KEY (id_usuarios, id_responsabilidad);


--
-- Name: usuarios_docente fk_id_carrera; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_docente
    ADD CONSTRAINT fk_id_carrera FOREIGN KEY (id_carrera) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: carreras_evidencias fk_id_carrera; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT fk_id_carrera FOREIGN KEY (id_carrera) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- Name: carreras_periodo_academico fk_id_carreras; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_periodo_academico
    ADD CONSTRAINT fk_id_carreras FOREIGN KEY (id_carreras) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: docentes_carreras fk_id_carreras; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.docentes_carreras
    ADD CONSTRAINT fk_id_carreras FOREIGN KEY (id_carreras) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: estandar fk_id_criterios; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estandar
    ADD CONSTRAINT fk_id_criterios FOREIGN KEY (id_criterio) REFERENCES public.criterios(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- Name: docentes_carreras fk_id_docentes; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.docentes_carreras
    ADD CONSTRAINT fk_id_docentes FOREIGN KEY (id_docentes) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: usuarios_responsabilidad fk_id_docentes; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT fk_id_docentes FOREIGN KEY (id_docentes) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- Name: usuarios_docente fk_id_docentes; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_docente
    ADD CONSTRAINT fk_id_docentes FOREIGN KEY (id_docentes) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: elemento_fundamental fk_id_estandar; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.elemento_fundamental
    ADD CONSTRAINT fk_id_estandar FOREIGN KEY (id_estandar) REFERENCES public.estandar(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- Name: responsabilidad fk_id_evidencias; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.responsabilidad
    ADD CONSTRAINT fk_id_evidencias FOREIGN KEY (id_evidencias) REFERENCES public.evidencias(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: carreras_evidencias fk_id_evidencias; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT fk_id_evidencias FOREIGN KEY (id_evidencias) REFERENCES public.evidencias(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: carreras fk_id_facultad; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras
    ADD CONSTRAINT fk_id_facultad FOREIGN KEY (id_facultad) REFERENCES public.facultad(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;


--
-- Name: carreras_periodo_academico fk_id_periodo_academico; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_periodo_academico
    ADD CONSTRAINT fk_id_periodo_academico FOREIGN KEY (id_periodo_academico) REFERENCES public.periodo_academicos(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: carreras_evidencias fk_id_periodo_academico; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT fk_id_periodo_academico FOREIGN KEY (id_periodo_academico) REFERENCES public.periodo_academicos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: usuarios_responsabilidad fk_id_responsabilidad; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT fk_id_responsabilidad FOREIGN KEY (id_responsabilidad) REFERENCES public.responsabilidad(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: titulos fk_id_usuario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.titulos
    ADD CONSTRAINT fk_id_usuario FOREIGN KEY (id_docente) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: usuarios_responsabilidad fk_id_usuario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT fk_id_usuario FOREIGN KEY (id_usuarios) REFERENCES public.usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: historial_usuarios fk_id_usuarios; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.historial_usuarios
    ADD CONSTRAINT fk_id_usuarios FOREIGN KEY (id_usuarios) REFERENCES public.usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: periodo_academico_usuarios fk_id_usuarios; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.periodo_academico_usuarios
    ADD CONSTRAINT fk_id_usuarios FOREIGN KEY (id_usuarios) REFERENCES public.usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: usuarios_docente fk_id_usuarios; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios_docente
    ADD CONSTRAINT fk_id_usuarios FOREIGN KEY (id_usuarios) REFERENCES public.usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: periodo_academico_usuarios fk_periodo_academico; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.periodo_academico_usuarios
    ADD CONSTRAINT fk_periodo_academico FOREIGN KEY (id_periodo_academico) REFERENCES public.periodo_academicos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: evaluacion_docentes id_docente; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluacion_docentes
    ADD CONSTRAINT id_docente FOREIGN KEY (id_docente) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: evaluacion_docentes id_evaluacion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluacion_docentes
    ADD CONSTRAINT id_evaluacion FOREIGN KEY (id_evaluacion) REFERENCES public.evaluacion(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- PostgreSQL database dump complete
--

