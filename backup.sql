PGDMP     	    (            
    z         	   seac_2022    12.1    12.1 �    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    82601 	   seac_2022    DATABASE     �   CREATE DATABASE seac_2022 WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Spanish_Spain.1252' LC_CTYPE = 'Spanish_Spain.1252';
    DROP DATABASE seac_2022;
                postgres    false            �            1259    82610    carreras    TABLE     �   CREATE TABLE public.carreras (
    id character(8) NOT NULL,
    nombre text NOT NULL,
    id_facultad character(8) NOT NULL,
    numero_asig integer NOT NULL,
    total_horas_proyecto integer NOT NULL
);
    DROP TABLE public.carreras;
       public         heap    postgres    false            �            1259    82873    carreras_evidencias    TABLE     �   CREATE TABLE public.carreras_evidencias (
    id_periodo_academico character(10) NOT NULL,
    id_evidencias text NOT NULL,
    id_carrera character(8) NOT NULL,
    cod_evidencia character(15) NOT NULL
);
 '   DROP TABLE public.carreras_evidencias;
       public         heap    postgres    false            �            1259    82765    carreras_periodo_academico    TABLE     �   CREATE TABLE public.carreras_periodo_academico (
    id_carreras character(8) NOT NULL,
    id_periodo_academico character(10) NOT NULL
);
 .   DROP TABLE public.carreras_periodo_academico;
       public         heap    postgres    false            �            1259    82690 	   criterios    TABLE     e   CREATE TABLE public.criterios (
    id character(15) NOT NULL,
    nombre character(120) NOT NULL
);
    DROP TABLE public.criterios;
       public         heap    postgres    false            �            1259    82623    docentes    TABLE     �   CREATE TABLE public.docentes (
    id character(10) NOT NULL,
    nombre text NOT NULL,
    correo text NOT NULL,
    clave character(500),
    telefono character(10),
    cambio_clave boolean NOT NULL,
    apellido text NOT NULL
);
    DROP TABLE public.docentes;
       public         heap    postgres    false            �            1259    90791    docentes_carreras    TABLE     y   CREATE TABLE public.docentes_carreras (
    id_carreras character(8) NOT NULL,
    id_docentes character(10) NOT NULL
);
 %   DROP TABLE public.docentes_carreras;
       public         heap    postgres    false            �            1259    82674    elemento_fundamental    TABLE     �   CREATE TABLE public.elemento_fundamental (
    id character(15) NOT NULL,
    descripcion text NOT NULL,
    id_estandar character(15) NOT NULL
);
 (   DROP TABLE public.elemento_fundamental;
       public         heap    postgres    false            �            1259    82682    estandar    TABLE     �   CREATE TABLE public.estandar (
    id character(15) NOT NULL,
    descripcion text NOT NULL,
    id_criterio character(15) NOT NULL
);
    DROP TABLE public.estandar;
       public         heap    postgres    false            �            1259    82844 
   evaluacion    TABLE     S   CREATE TABLE public.evaluacion (
    id bigint NOT NULL,
    nota text NOT NULL
);
    DROP TABLE public.evaluacion;
       public         heap    postgres    false            �            1259    82855    evaluacion_docentes    TABLE     v   CREATE TABLE public.evaluacion_docentes (
    id_evaluacion bigint NOT NULL,
    id_docente character(10) NOT NULL
);
 '   DROP TABLE public.evaluacion_docentes;
       public         heap    postgres    false            �            1259    82842    evaluacion_id_seq    SEQUENCE     z   CREATE SEQUENCE public.evaluacion_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.evaluacion_id_seq;
       public          postgres    false    226            �           0    0    evaluacion_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.evaluacion_id_seq OWNED BY public.evaluacion.id;
          public          postgres    false    225            �            1259    82853 $   evalucion_docentes_id_evaluacion_seq    SEQUENCE     �   CREATE SEQUENCE public.evalucion_docentes_id_evaluacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE public.evalucion_docentes_id_evaluacion_seq;
       public          postgres    false    228            �           0    0 $   evalucion_docentes_id_evaluacion_seq    SEQUENCE OWNED BY     n   ALTER SEQUENCE public.evalucion_docentes_id_evaluacion_seq OWNED BY public.evaluacion_docentes.id_evaluacion;
          public          postgres    false    227            �            1259    82666 
   evidencias    TABLE     S   CREATE TABLE public.evidencias (
    id text NOT NULL,
    nombre text NOT NULL
);
    DROP TABLE public.evidencias;
       public         heap    postgres    false            �            1259    82602    facultad    TABLE     Y   CREATE TABLE public.facultad (
    id character(8) NOT NULL,
    nombre text NOT NULL
);
    DROP TABLE public.facultad;
       public         heap    postgres    false            �            1259    82651    historial_usuarios    TABLE     �   CREATE TABLE public.historial_usuarios (
    id bigint NOT NULL,
    fecha_inicial date NOT NULL,
    fecha_final date NOT NULL,
    id_usuarios integer NOT NULL,
    responsabilidad text NOT NULL
);
 &   DROP TABLE public.historial_usuarios;
       public         heap    postgres    false            �            1259    82647    historial_usuarios_id_seq    SEQUENCE     �   CREATE SEQUENCE public.historial_usuarios_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.historial_usuarios_id_seq;
       public          postgres    false    210            �           0    0    historial_usuarios_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.historial_usuarios_id_seq OWNED BY public.historial_usuarios.id;
          public          postgres    false    208            �            1259    82649 "   historial_usuarios_id_usuarios_seq    SEQUENCE     �   CREATE SEQUENCE public.historial_usuarios_id_usuarios_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 9   DROP SEQUENCE public.historial_usuarios_id_usuarios_seq;
       public          postgres    false    210            �           0    0 "   historial_usuarios_id_usuarios_seq    SEQUENCE OWNED BY     i   ALTER SEQUENCE public.historial_usuarios_id_usuarios_seq OWNED BY public.historial_usuarios.id_usuarios;
          public          postgres    false    209            �            1259    82782    periodo_academico_usuarios    TABLE     �   CREATE TABLE public.periodo_academico_usuarios (
    id_periodo_academico character(10) NOT NULL,
    id_usuarios integer NOT NULL
);
 .   DROP TABLE public.periodo_academico_usuarios;
       public         heap    postgres    false            �            1259    82780 *   periodo_academico_usuarios_id_usuarios_seq    SEQUENCE     �   CREATE SEQUENCE public.periodo_academico_usuarios_id_usuarios_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 A   DROP SEQUENCE public.periodo_academico_usuarios_id_usuarios_seq;
       public          postgres    false    221            �           0    0 *   periodo_academico_usuarios_id_usuarios_seq    SEQUENCE OWNED BY     y   ALTER SEQUENCE public.periodo_academico_usuarios_id_usuarios_seq OWNED BY public.periodo_academico_usuarios.id_usuarios;
          public          postgres    false    220            �            1259    82631    periodo_academicos    TABLE     �   CREATE TABLE public.periodo_academicos (
    id character(10) NOT NULL,
    fecha_inicial date NOT NULL,
    fecha_final date NOT NULL
);
 &   DROP TABLE public.periodo_academicos;
       public         heap    postgres    false            �            1259    99017    prueba    TABLE     �   CREATE TABLE public.prueba (
    id character(3) NOT NULL,
    nombre character(25),
    apellido character(25),
    direcion character(40)
);
    DROP TABLE public.prueba;
       public         heap    postgres    false            �            1259    82723    responsabilidad    TABLE     {   CREATE TABLE public.responsabilidad (
    id bigint NOT NULL,
    nombre text NOT NULL,
    id_evidencias text NOT NULL
);
 #   DROP TABLE public.responsabilidad;
       public         heap    postgres    false            �            1259    82721    responsabilidad_id_seq    SEQUENCE        CREATE SEQUENCE public.responsabilidad_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.responsabilidad_id_seq;
       public          postgres    false    216            �           0    0    responsabilidad_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.responsabilidad_id_seq OWNED BY public.responsabilidad.id;
          public          postgres    false    215            �            1259    82750    titulos    TABLE     y   CREATE TABLE public.titulos (
    id bigint NOT NULL,
    nombre text NOT NULL,
    id_docente character(10) NOT NULL
);
    DROP TABLE public.titulos;
       public         heap    postgres    false            �            1259    82748    titulos_id_seq    SEQUENCE     w   CREATE SEQUENCE public.titulos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.titulos_id_seq;
       public          postgres    false    218            �           0    0    titulos_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.titulos_id_seq OWNED BY public.titulos.id;
          public          postgres    false    217            �            1259    82638    usuarios    TABLE     m   CREATE TABLE public.usuarios (
    id integer NOT NULL,
    decripcion text NOT NULL,
    permisos bigint
);
    DROP TABLE public.usuarios;
       public         heap    postgres    false            �            1259    107211    usuarios_docente    TABLE     �   CREATE TABLE public.usuarios_docente (
    id_usuarios integer NOT NULL,
    id_docentes character(10) NOT NULL,
    id_carrera character(8) NOT NULL,
    fecha_inicial date NOT NULL,
    fecha_final date NOT NULL,
    estado character(10) NOT NULL
);
 $   DROP TABLE public.usuarios_docente;
       public         heap    postgres    false            �            1259    82636    usuarios_id_seq    SEQUENCE     �   CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.usuarios_id_seq;
       public          postgres    false    207            �           0    0    usuarios_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;
          public          postgres    false    206            �            1259    82802    usuarios_responsabilidad    TABLE     �   CREATE TABLE public.usuarios_responsabilidad (
    id_usuarios integer NOT NULL,
    id_responsabilidad bigint NOT NULL,
    id_docentes character(10) NOT NULL
);
 ,   DROP TABLE public.usuarios_responsabilidad;
       public         heap    postgres    false            �            1259    82800 /   usuarios_responsabilidad_id_responsabilidad_seq    SEQUENCE     �   CREATE SEQUENCE public.usuarios_responsabilidad_id_responsabilidad_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 F   DROP SEQUENCE public.usuarios_responsabilidad_id_responsabilidad_seq;
       public          postgres    false    224            �           0    0 /   usuarios_responsabilidad_id_responsabilidad_seq    SEQUENCE OWNED BY     �   ALTER SEQUENCE public.usuarios_responsabilidad_id_responsabilidad_seq OWNED BY public.usuarios_responsabilidad.id_responsabilidad;
          public          postgres    false    223            �            1259    82798 (   usuarios_responsabilidad_id_usuarios_seq    SEQUENCE     �   CREATE SEQUENCE public.usuarios_responsabilidad_id_usuarios_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ?   DROP SEQUENCE public.usuarios_responsabilidad_id_usuarios_seq;
       public          postgres    false    224            �           0    0 (   usuarios_responsabilidad_id_usuarios_seq    SEQUENCE OWNED BY     u   ALTER SEQUENCE public.usuarios_responsabilidad_id_usuarios_seq OWNED BY public.usuarios_responsabilidad.id_usuarios;
          public          postgres    false    222            �
           2604    82847    evaluacion id    DEFAULT     n   ALTER TABLE ONLY public.evaluacion ALTER COLUMN id SET DEFAULT nextval('public.evaluacion_id_seq'::regclass);
 <   ALTER TABLE public.evaluacion ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    226    225    226            �
           2604    82858 !   evaluacion_docentes id_evaluacion    DEFAULT     �   ALTER TABLE ONLY public.evaluacion_docentes ALTER COLUMN id_evaluacion SET DEFAULT nextval('public.evalucion_docentes_id_evaluacion_seq'::regclass);
 P   ALTER TABLE public.evaluacion_docentes ALTER COLUMN id_evaluacion DROP DEFAULT;
       public          postgres    false    227    228    228            �
           2604    82654    historial_usuarios id    DEFAULT     ~   ALTER TABLE ONLY public.historial_usuarios ALTER COLUMN id SET DEFAULT nextval('public.historial_usuarios_id_seq'::regclass);
 D   ALTER TABLE public.historial_usuarios ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    208    210    210            �
           2604    82655    historial_usuarios id_usuarios    DEFAULT     �   ALTER TABLE ONLY public.historial_usuarios ALTER COLUMN id_usuarios SET DEFAULT nextval('public.historial_usuarios_id_usuarios_seq'::regclass);
 M   ALTER TABLE public.historial_usuarios ALTER COLUMN id_usuarios DROP DEFAULT;
       public          postgres    false    209    210    210            �
           2604    82785 &   periodo_academico_usuarios id_usuarios    DEFAULT     �   ALTER TABLE ONLY public.periodo_academico_usuarios ALTER COLUMN id_usuarios SET DEFAULT nextval('public.periodo_academico_usuarios_id_usuarios_seq'::regclass);
 U   ALTER TABLE public.periodo_academico_usuarios ALTER COLUMN id_usuarios DROP DEFAULT;
       public          postgres    false    220    221    221            �
           2604    82726    responsabilidad id    DEFAULT     x   ALTER TABLE ONLY public.responsabilidad ALTER COLUMN id SET DEFAULT nextval('public.responsabilidad_id_seq'::regclass);
 A   ALTER TABLE public.responsabilidad ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    216    215    216            �
           2604    82753 
   titulos id    DEFAULT     h   ALTER TABLE ONLY public.titulos ALTER COLUMN id SET DEFAULT nextval('public.titulos_id_seq'::regclass);
 9   ALTER TABLE public.titulos ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    218    217    218            �
           2604    82641    usuarios id    DEFAULT     j   ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);
 :   ALTER TABLE public.usuarios ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    206    207    207            �
           2604    82805 $   usuarios_responsabilidad id_usuarios    DEFAULT     �   ALTER TABLE ONLY public.usuarios_responsabilidad ALTER COLUMN id_usuarios SET DEFAULT nextval('public.usuarios_responsabilidad_id_usuarios_seq'::regclass);
 S   ALTER TABLE public.usuarios_responsabilidad ALTER COLUMN id_usuarios DROP DEFAULT;
       public          postgres    false    224    222    224            �
           2604    82806 +   usuarios_responsabilidad id_responsabilidad    DEFAULT     �   ALTER TABLE ONLY public.usuarios_responsabilidad ALTER COLUMN id_responsabilidad SET DEFAULT nextval('public.usuarios_responsabilidad_id_responsabilidad_seq'::regclass);
 Z   ALTER TABLE public.usuarios_responsabilidad ALTER COLUMN id_responsabilidad DROP DEFAULT;
       public          postgres    false    224    223    224            �          0    82610    carreras 
   TABLE DATA           ^   COPY public.carreras (id, nombre, id_facultad, numero_asig, total_horas_proyecto) FROM stdin;
    public          postgres    false    203   ��       �          0    82873    carreras_evidencias 
   TABLE DATA           m   COPY public.carreras_evidencias (id_periodo_academico, id_evidencias, id_carrera, cod_evidencia) FROM stdin;
    public          postgres    false    229   ��       �          0    82765    carreras_periodo_academico 
   TABLE DATA           W   COPY public.carreras_periodo_academico (id_carreras, id_periodo_academico) FROM stdin;
    public          postgres    false    219   ��       �          0    82690 	   criterios 
   TABLE DATA           /   COPY public.criterios (id, nombre) FROM stdin;
    public          postgres    false    214   ,�       �          0    82623    docentes 
   TABLE DATA           _   COPY public.docentes (id, nombre, correo, clave, telefono, cambio_clave, apellido) FROM stdin;
    public          postgres    false    204   \�       �          0    90791    docentes_carreras 
   TABLE DATA           E   COPY public.docentes_carreras (id_carreras, id_docentes) FROM stdin;
    public          postgres    false    230   ��       �          0    82674    elemento_fundamental 
   TABLE DATA           L   COPY public.elemento_fundamental (id, descripcion, id_estandar) FROM stdin;
    public          postgres    false    212   z�       �          0    82682    estandar 
   TABLE DATA           @   COPY public.estandar (id, descripcion, id_criterio) FROM stdin;
    public          postgres    false    213   ��       �          0    82844 
   evaluacion 
   TABLE DATA           .   COPY public.evaluacion (id, nota) FROM stdin;
    public          postgres    false    226   ��       �          0    82855    evaluacion_docentes 
   TABLE DATA           H   COPY public.evaluacion_docentes (id_evaluacion, id_docente) FROM stdin;
    public          postgres    false    228   ѭ       �          0    82666 
   evidencias 
   TABLE DATA           0   COPY public.evidencias (id, nombre) FROM stdin;
    public          postgres    false    211   �       �          0    82602    facultad 
   TABLE DATA           .   COPY public.facultad (id, nombre) FROM stdin;
    public          postgres    false    202   �       �          0    82651    historial_usuarios 
   TABLE DATA           j   COPY public.historial_usuarios (id, fecha_inicial, fecha_final, id_usuarios, responsabilidad) FROM stdin;
    public          postgres    false    210   ��       �          0    82782    periodo_academico_usuarios 
   TABLE DATA           W   COPY public.periodo_academico_usuarios (id_periodo_academico, id_usuarios) FROM stdin;
    public          postgres    false    221   ۮ       �          0    82631    periodo_academicos 
   TABLE DATA           L   COPY public.periodo_academicos (id, fecha_inicial, fecha_final) FROM stdin;
    public          postgres    false    205   ��       �          0    99017    prueba 
   TABLE DATA           @   COPY public.prueba (id, nombre, apellido, direcion) FROM stdin;
    public          postgres    false    231   L�       �          0    82723    responsabilidad 
   TABLE DATA           D   COPY public.responsabilidad (id, nombre, id_evidencias) FROM stdin;
    public          postgres    false    216   i�       �          0    82750    titulos 
   TABLE DATA           9   COPY public.titulos (id, nombre, id_docente) FROM stdin;
    public          postgres    false    218   ��       �          0    82638    usuarios 
   TABLE DATA           <   COPY public.usuarios (id, decripcion, permisos) FROM stdin;
    public          postgres    false    207   ��       �          0    107211    usuarios_docente 
   TABLE DATA           t   COPY public.usuarios_docente (id_usuarios, id_docentes, id_carrera, fecha_inicial, fecha_final, estado) FROM stdin;
    public          postgres    false    232   �       �          0    82802    usuarios_responsabilidad 
   TABLE DATA           `   COPY public.usuarios_responsabilidad (id_usuarios, id_responsabilidad, id_docentes) FROM stdin;
    public          postgres    false    224   �       �           0    0    evaluacion_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.evaluacion_id_seq', 1, false);
          public          postgres    false    225            �           0    0 $   evalucion_docentes_id_evaluacion_seq    SEQUENCE SET     S   SELECT pg_catalog.setval('public.evalucion_docentes_id_evaluacion_seq', 1, false);
          public          postgres    false    227            �           0    0    historial_usuarios_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.historial_usuarios_id_seq', 1, false);
          public          postgres    false    208            �           0    0 "   historial_usuarios_id_usuarios_seq    SEQUENCE SET     Q   SELECT pg_catalog.setval('public.historial_usuarios_id_usuarios_seq', 1, false);
          public          postgres    false    209            �           0    0 *   periodo_academico_usuarios_id_usuarios_seq    SEQUENCE SET     Y   SELECT pg_catalog.setval('public.periodo_academico_usuarios_id_usuarios_seq', 1, false);
          public          postgres    false    220            �           0    0    responsabilidad_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.responsabilidad_id_seq', 1, false);
          public          postgres    false    215            �           0    0    titulos_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.titulos_id_seq', 1, false);
          public          postgres    false    217            �           0    0    usuarios_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.usuarios_id_seq', 4, true);
          public          postgres    false    206            �           0    0 /   usuarios_responsabilidad_id_responsabilidad_seq    SEQUENCE SET     ^   SELECT pg_catalog.setval('public.usuarios_responsabilidad_id_responsabilidad_seq', 1, false);
          public          postgres    false    223            �           0    0 (   usuarios_responsabilidad_id_usuarios_seq    SEQUENCE SET     W   SELECT pg_catalog.setval('public.usuarios_responsabilidad_id_usuarios_seq', 1, false);
          public          postgres    false    222                       2606    148175 ,   carreras_evidencias carreras_evidencias_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT carreras_evidencias_pkey PRIMARY KEY (id_carrera, cod_evidencia, id_evidencias, id_periodo_academico);
 V   ALTER TABLE ONLY public.carreras_evidencias DROP CONSTRAINT carreras_evidencias_pkey;
       public            postgres    false    229    229    229    229                       2606    82769 :   carreras_periodo_academico carreras_periodo_academico_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.carreras_periodo_academico
    ADD CONSTRAINT carreras_periodo_academico_pkey PRIMARY KEY (id_carreras, id_periodo_academico);
 d   ALTER TABLE ONLY public.carreras_periodo_academico DROP CONSTRAINT carreras_periodo_academico_pkey;
       public            postgres    false    219    219            �
           2606    82617    carreras carreras_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.carreras
    ADD CONSTRAINT carreras_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.carreras DROP CONSTRAINT carreras_pkey;
       public            postgres    false    203            
           2606    82694    criterios criterios_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.criterios
    ADD CONSTRAINT criterios_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.criterios DROP CONSTRAINT criterios_pkey;
       public            postgres    false    214                       2606    90795 (   docentes_carreras docentes_carreras_pkey 
   CONSTRAINT     |   ALTER TABLE ONLY public.docentes_carreras
    ADD CONSTRAINT docentes_carreras_pkey PRIMARY KEY (id_carreras, id_docentes);
 R   ALTER TABLE ONLY public.docentes_carreras DROP CONSTRAINT docentes_carreras_pkey;
       public            postgres    false    230    230            �
           2606    82630    docentes docentes_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.docentes
    ADD CONSTRAINT docentes_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.docentes DROP CONSTRAINT docentes_pkey;
       public            postgres    false    204                       2606    82681 .   elemento_fundamental elemento_fundamental_pkey 
   CONSTRAINT     l   ALTER TABLE ONLY public.elemento_fundamental
    ADD CONSTRAINT elemento_fundamental_pkey PRIMARY KEY (id);
 X   ALTER TABLE ONLY public.elemento_fundamental DROP CONSTRAINT elemento_fundamental_pkey;
       public            postgres    false    212                       2606    82689    estandar estandar_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.estandar
    ADD CONSTRAINT estandar_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.estandar DROP CONSTRAINT estandar_pkey;
       public            postgres    false    213                       2606    82852    evaluacion evaluacion_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.evaluacion
    ADD CONSTRAINT evaluacion_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.evaluacion DROP CONSTRAINT evaluacion_pkey;
       public            postgres    false    226                       2606    82860 +   evaluacion_docentes evalucion_docentes_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.evaluacion_docentes
    ADD CONSTRAINT evalucion_docentes_pkey PRIMARY KEY (id_evaluacion, id_docente);
 U   ALTER TABLE ONLY public.evaluacion_docentes DROP CONSTRAINT evalucion_docentes_pkey;
       public            postgres    false    228    228                       2606    82673    evidencias evidencias_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.evidencias
    ADD CONSTRAINT evidencias_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.evidencias DROP CONSTRAINT evidencias_pkey;
       public            postgres    false    211            �
           2606    82609    facultad facultad_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.facultad
    ADD CONSTRAINT facultad_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.facultad DROP CONSTRAINT facultad_pkey;
       public            postgres    false    202                       2606    82660 *   historial_usuarios historial_usuarios_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.historial_usuarios
    ADD CONSTRAINT historial_usuarios_pkey PRIMARY KEY (id);
 T   ALTER TABLE ONLY public.historial_usuarios DROP CONSTRAINT historial_usuarios_pkey;
       public            postgres    false    210            �
           2606    82635 )   periodo_academicos periodo_academico_pkey 
   CONSTRAINT     g   ALTER TABLE ONLY public.periodo_academicos
    ADD CONSTRAINT periodo_academico_pkey PRIMARY KEY (id);
 S   ALTER TABLE ONLY public.periodo_academicos DROP CONSTRAINT periodo_academico_pkey;
       public            postgres    false    205                       2606    82787 :   periodo_academico_usuarios periodo_academico_usuarios_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.periodo_academico_usuarios
    ADD CONSTRAINT periodo_academico_usuarios_pkey PRIMARY KEY (id_periodo_academico, id_usuarios);
 d   ALTER TABLE ONLY public.periodo_academico_usuarios DROP CONSTRAINT periodo_academico_usuarios_pkey;
       public            postgres    false    221    221                        2606    99021    prueba prueba_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.prueba
    ADD CONSTRAINT prueba_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.prueba DROP CONSTRAINT prueba_pkey;
       public            postgres    false    231                       2606    82731 $   responsabilidad responsabilidad_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.responsabilidad
    ADD CONSTRAINT responsabilidad_pkey PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.responsabilidad DROP CONSTRAINT responsabilidad_pkey;
       public            postgres    false    216                       2606    82758    titulos titulos_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.titulos
    ADD CONSTRAINT titulos_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.titulos DROP CONSTRAINT titulos_pkey;
       public            postgres    false    218                       2606    148177 #   carreras_evidencias u_cod_evidencia 
   CONSTRAINT        ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT u_cod_evidencia UNIQUE (cod_evidencia) INCLUDE (cod_evidencia);
 M   ALTER TABLE ONLY public.carreras_evidencias DROP CONSTRAINT u_cod_evidencia;
       public            postgres    false    229    229            "           2606    107215 &   usuarios_docente usuarios_docente_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.usuarios_docente
    ADD CONSTRAINT usuarios_docente_pkey PRIMARY KEY (id_usuarios, id_docentes, id_carrera);
 P   ALTER TABLE ONLY public.usuarios_docente DROP CONSTRAINT usuarios_docente_pkey;
       public            postgres    false    232    232    232                        2606    82646    usuarios usuarios_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_pkey;
       public            postgres    false    207                       2606    82808 6   usuarios_responsabilidad usuarios_responsabilidad_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT usuarios_responsabilidad_pkey PRIMARY KEY (id_usuarios, id_responsabilidad);
 `   ALTER TABLE ONLY public.usuarios_responsabilidad DROP CONSTRAINT usuarios_responsabilidad_pkey;
       public            postgres    false    224    224            9           2606    107226    usuarios_docente fk_id_carrera    FK CONSTRAINT     �   ALTER TABLE ONLY public.usuarios_docente
    ADD CONSTRAINT fk_id_carrera FOREIGN KEY (id_carrera) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 H   ALTER TABLE ONLY public.usuarios_docente DROP CONSTRAINT fk_id_carrera;
       public          postgres    false    2810    203    232            4           2606    148178 !   carreras_evidencias fk_id_carrera    FK CONSTRAINT     �   ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT fk_id_carrera FOREIGN KEY (id_carrera) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;
 K   ALTER TABLE ONLY public.carreras_evidencias DROP CONSTRAINT fk_id_carrera;
       public          postgres    false    203    2810    229            )           2606    82770 )   carreras_periodo_academico fk_id_carreras    FK CONSTRAINT     �   ALTER TABLE ONLY public.carreras_periodo_academico
    ADD CONSTRAINT fk_id_carreras FOREIGN KEY (id_carreras) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 S   ALTER TABLE ONLY public.carreras_periodo_academico DROP CONSTRAINT fk_id_carreras;
       public          postgres    false    219    203    2810            5           2606    90796     docentes_carreras fk_id_carreras    FK CONSTRAINT     �   ALTER TABLE ONLY public.docentes_carreras
    ADD CONSTRAINT fk_id_carreras FOREIGN KEY (id_carreras) REFERENCES public.carreras(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 J   ALTER TABLE ONLY public.docentes_carreras DROP CONSTRAINT fk_id_carreras;
       public          postgres    false    203    2810    230            &           2606    82700    estandar fk_id_criterios    FK CONSTRAINT     �   ALTER TABLE ONLY public.estandar
    ADD CONSTRAINT fk_id_criterios FOREIGN KEY (id_criterio) REFERENCES public.criterios(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;
 B   ALTER TABLE ONLY public.estandar DROP CONSTRAINT fk_id_criterios;
       public          postgres    false    214    2826    213            6           2606    90801     docentes_carreras fk_id_docentes    FK CONSTRAINT     �   ALTER TABLE ONLY public.docentes_carreras
    ADD CONSTRAINT fk_id_docentes FOREIGN KEY (id_docentes) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 J   ALTER TABLE ONLY public.docentes_carreras DROP CONSTRAINT fk_id_docentes;
       public          postgres    false    230    2812    204            /           2606    90820 '   usuarios_responsabilidad fk_id_docentes    FK CONSTRAINT     �   ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT fk_id_docentes FOREIGN KEY (id_docentes) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;
 Q   ALTER TABLE ONLY public.usuarios_responsabilidad DROP CONSTRAINT fk_id_docentes;
       public          postgres    false    2812    204    224            8           2606    107221    usuarios_docente fk_id_docentes    FK CONSTRAINT     �   ALTER TABLE ONLY public.usuarios_docente
    ADD CONSTRAINT fk_id_docentes FOREIGN KEY (id_docentes) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 I   ALTER TABLE ONLY public.usuarios_docente DROP CONSTRAINT fk_id_docentes;
       public          postgres    false    232    2812    204            %           2606    82695 #   elemento_fundamental fk_id_estandar    FK CONSTRAINT     �   ALTER TABLE ONLY public.elemento_fundamental
    ADD CONSTRAINT fk_id_estandar FOREIGN KEY (id_estandar) REFERENCES public.estandar(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;
 M   ALTER TABLE ONLY public.elemento_fundamental DROP CONSTRAINT fk_id_estandar;
       public          postgres    false    2824    212    213            '           2606    82732     responsabilidad fk_id_evidencias    FK CONSTRAINT     �   ALTER TABLE ONLY public.responsabilidad
    ADD CONSTRAINT fk_id_evidencias FOREIGN KEY (id_evidencias) REFERENCES public.evidencias(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 J   ALTER TABLE ONLY public.responsabilidad DROP CONSTRAINT fk_id_evidencias;
       public          postgres    false    211    216    2820            2           2606    82889 $   carreras_evidencias fk_id_evidencias    FK CONSTRAINT     �   ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT fk_id_evidencias FOREIGN KEY (id_evidencias) REFERENCES public.evidencias(id) ON UPDATE RESTRICT ON DELETE RESTRICT;
 N   ALTER TABLE ONLY public.carreras_evidencias DROP CONSTRAINT fk_id_evidencias;
       public          postgres    false    211    2820    229            #           2606    123593    carreras fk_id_facultad    FK CONSTRAINT     �   ALTER TABLE ONLY public.carreras
    ADD CONSTRAINT fk_id_facultad FOREIGN KEY (id_facultad) REFERENCES public.facultad(id) ON UPDATE CASCADE ON DELETE RESTRICT NOT VALID;
 A   ALTER TABLE ONLY public.carreras DROP CONSTRAINT fk_id_facultad;
       public          postgres    false    2808    203    202            *           2606    82775 2   carreras_periodo_academico fk_id_periodo_academico    FK CONSTRAINT     �   ALTER TABLE ONLY public.carreras_periodo_academico
    ADD CONSTRAINT fk_id_periodo_academico FOREIGN KEY (id_periodo_academico) REFERENCES public.periodo_academicos(id) ON UPDATE RESTRICT ON DELETE RESTRICT;
 \   ALTER TABLE ONLY public.carreras_periodo_academico DROP CONSTRAINT fk_id_periodo_academico;
       public          postgres    false    219    205    2814            3           2606    148169 +   carreras_evidencias fk_id_periodo_academico    FK CONSTRAINT     �   ALTER TABLE ONLY public.carreras_evidencias
    ADD CONSTRAINT fk_id_periodo_academico FOREIGN KEY (id_periodo_academico) REFERENCES public.periodo_academicos(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 U   ALTER TABLE ONLY public.carreras_evidencias DROP CONSTRAINT fk_id_periodo_academico;
       public          postgres    false    205    2814    229            .           2606    82814 .   usuarios_responsabilidad fk_id_responsabilidad    FK CONSTRAINT     �   ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT fk_id_responsabilidad FOREIGN KEY (id_responsabilidad) REFERENCES public.responsabilidad(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 X   ALTER TABLE ONLY public.usuarios_responsabilidad DROP CONSTRAINT fk_id_responsabilidad;
       public          postgres    false    216    224    2828            (           2606    82759    titulos fk_id_usuario    FK CONSTRAINT     �   ALTER TABLE ONLY public.titulos
    ADD CONSTRAINT fk_id_usuario FOREIGN KEY (id_docente) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 ?   ALTER TABLE ONLY public.titulos DROP CONSTRAINT fk_id_usuario;
       public          postgres    false    204    218    2812            -           2606    82809 &   usuarios_responsabilidad fk_id_usuario    FK CONSTRAINT     �   ALTER TABLE ONLY public.usuarios_responsabilidad
    ADD CONSTRAINT fk_id_usuario FOREIGN KEY (id_usuarios) REFERENCES public.usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 P   ALTER TABLE ONLY public.usuarios_responsabilidad DROP CONSTRAINT fk_id_usuario;
       public          postgres    false    2816    207    224            $           2606    82661 !   historial_usuarios fk_id_usuarios    FK CONSTRAINT     �   ALTER TABLE ONLY public.historial_usuarios
    ADD CONSTRAINT fk_id_usuarios FOREIGN KEY (id_usuarios) REFERENCES public.usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 K   ALTER TABLE ONLY public.historial_usuarios DROP CONSTRAINT fk_id_usuarios;
       public          postgres    false    210    2816    207            ,           2606    82793 )   periodo_academico_usuarios fk_id_usuarios    FK CONSTRAINT     �   ALTER TABLE ONLY public.periodo_academico_usuarios
    ADD CONSTRAINT fk_id_usuarios FOREIGN KEY (id_usuarios) REFERENCES public.usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 S   ALTER TABLE ONLY public.periodo_academico_usuarios DROP CONSTRAINT fk_id_usuarios;
       public          postgres    false    207    2816    221            7           2606    107216    usuarios_docente fk_id_usuarios    FK CONSTRAINT     �   ALTER TABLE ONLY public.usuarios_docente
    ADD CONSTRAINT fk_id_usuarios FOREIGN KEY (id_usuarios) REFERENCES public.usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 I   ALTER TABLE ONLY public.usuarios_docente DROP CONSTRAINT fk_id_usuarios;
       public          postgres    false    207    2816    232            +           2606    82788 /   periodo_academico_usuarios fk_periodo_academico    FK CONSTRAINT     �   ALTER TABLE ONLY public.periodo_academico_usuarios
    ADD CONSTRAINT fk_periodo_academico FOREIGN KEY (id_periodo_academico) REFERENCES public.periodo_academicos(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 Y   ALTER TABLE ONLY public.periodo_academico_usuarios DROP CONSTRAINT fk_periodo_academico;
       public          postgres    false    2814    221    205            1           2606    82866    evaluacion_docentes id_docente    FK CONSTRAINT     �   ALTER TABLE ONLY public.evaluacion_docentes
    ADD CONSTRAINT id_docente FOREIGN KEY (id_docente) REFERENCES public.docentes(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 H   ALTER TABLE ONLY public.evaluacion_docentes DROP CONSTRAINT id_docente;
       public          postgres    false    2812    228    204            0           2606    82861 !   evaluacion_docentes id_evaluacion    FK CONSTRAINT     �   ALTER TABLE ONLY public.evaluacion_docentes
    ADD CONSTRAINT id_evaluacion FOREIGN KEY (id_evaluacion) REFERENCES public.evaluacion(id) ON UPDATE CASCADE ON DELETE RESTRICT;
 K   ALTER TABLE ONLY public.evaluacion_docentes DROP CONSTRAINT id_evaluacion;
       public          postgres    false    2838    226    228            �   �   x�M�1��@Ek��@PfH��Y2�(R���%��"3ȉĩ�8cp
p�o=��ߘv�ā���C���΂J�ZΪ �3�1�D�fb�-Gh�V��@y�J<�6�@��tѠ@aw����y�Y��C��~�8&���/��2èU>��!t!!jӚw#������x �*Um���0:蓮m������4��N�jy�+D|��Gp      �      x������ � �      �   t   x�}�A
� D�y
/P4ޠ�-,P����oʅ��L�B��5�w�=?k�9m�EI^3Y��l�$^�M��p�Q�+��$���,?��t錯~ �d�d[ee�Y��3��N�      �       x�3T@��E%�y�yə�
�\1z\\\ g��      �   �  x��ɲ�X���.j��î��^PԨ�2���[�3�5ȭ�n+��^7�o���$���31��p�aYU~9��c#$���
�
�6򅨿�ؗc<�#º���&���q��jni���4Y��}�<�Ɨ(�ͩÞO	���3ͱ����(��p|Wc�4�q<K1�2-�P��" ��@�3Z�r�ɬ�e^, �g𤹞�s��r�Woϲ5�Z3A�+n���{��� 'D�pj��+]�a�	(�t��86(2��eÍ�@�/��2 y��qGp��s�V�5��.�9y5���M�_]u�s����	Hxk�K�t�����IZ� A���/�L����[{�����J�B��%d�k��I&�2�cb��ׁ|c�zu�=���P��Ҳ��y���8ҠS|��8���| M6Q=�HX�z��/\v���*�?{�����%��,{���2���̫��y�_�i����f8uvp�$	��k�^�t��8��\g����u��c�����/��.Z�	�oFT31��W�T�%����<���&�ܝj�hsM�E3,Ƿ������PS9������Ua�XzƖ����3�������d&�BB��5��篫����6���&��po1�*ؽ�4ͧS̈́j��xB�P&�$�l�˪[�%75�����fY;b�#�b��B5��/s����h�ax��I���S^5Ix�.�t9���_�Sl�9󝡛쥜��Ee*!��

���	V�5� �f{�znzʹ�c��/��ݮ-�� G�4��݊F��3G�N �����a}�����9l�8���U$S���q-��*��5<,l!L� )w�ITL�V���_��9��w��g���W��G�݆�{k�;���{'�s�n�5A%���$\��D��zg1������$Z�}R>n{��9pΠ�ԡ�f���6z�,��<pG�c����gI-���HPQE-ޯA����UFWY[�G���~���t���~����t�)���!��bjm,W��RsUL�\²��G�� K�,0;����"�����褸�(�����?����qNE�Q�(�X��ƌ�Z��娚y&W��#���u;uḠ�9���0����'����Ƕ�Ё����c�A�H      �   n   x�m�K
�0е9�'�~�4Y�VWZ�.��9,�HŬ�����sj�5�y$����ˌ#c���:����Ö��1рc�q��$�b�3Y�۟�����k���H%���	�C%�      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �   �   x�U�M
�0�����.�R*�к���i4IyI��\y�^�Ɲ��of-U��kIPƒ�YGz̹�i�8(��4���r7�vzEj��ȼ��J��m����)<�߬��FR���h�	�k��\�S�53L&�R���%���읷�[qY
!��w;�      �      x������ � �      �      x������ � �      �   D   x�E���0C�3���l�����A�B{���g�pξ}v�U4F�x�WC��A�W9`�sD��d�      �      x������ � �      �      x������ � �      �      x������ � �      �   \   x��1
� @�99EOPPD\K��tuh���[?�o<l��=4Q0DɕG�v-�8�ԞY-DҚ��r��5u�?�׊�:      �   �   x����n�0���S�Fwg�|7�4T
R`삘X�R���4P�P���O�����TD�w}��02;B�>�x������s��	C��	v����إ�C�Y/&��Ik�؇(Ia��o�6�N�+8�EMfA�뻶j�KdǕ$I�K���`���9fS�%CHQ�o�����$VI����0�2[@U-�r��c,��pr{M&��<N�a8��� 9?���J�c�4��c�8      �      x������ � �     