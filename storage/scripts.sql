CREATE TABLE IF NOT EXISTS public.users
(
    id serial,
    name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    email character varying(255) COLLATE pg_catalog."default" NOT NULL,
    email_verified_at timestamp(0) without time zone,
    username character varying(40) COLLATE pg_catalog."default",
    password character varying(255) COLLATE pg_catalog."default" NOT NULL,
    remember_token character varying(100) COLLATE pg_catalog."default",
    created_at timestamp(0) without time zone DEFAULT now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT users_pkey PRIMARY KEY (id),
    CONSTRAINT users_email_unique UNIQUE (email),
    CONSTRAINT users_username_unique UNIQUE (username)
);

CREATE TABLE IF NOT EXISTS public.instituciones
(
    id serial,
    nombre text COLLATE pg_catalog."default",
    siglas text COLLATE pg_catalog."default",
    campus text COLLATE pg_catalog."default",
    detalles text COLLATE pg_catalog."default",
    created_at timestamp(0) without time zone DEFAULT now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT instituciones_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.estudiantes
(
    id serial,
	numero_cuenta text,
    primer_nombre text,
    segundo_nombre text,
    primer_apellido text,
    segundo_apellido text,
	correo_electronico text,
	celular text,
	carrera text,
    created_at timestamp(0) without time zone DEFAULT now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT estudiantes_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.instituciones_estudiantes
(
    id serial,
	id_institucion integer,
    id_estudiante integer,
    created_at timestamp(0) without time zone DEFAULT now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT instituciones_estudiantes_pkey PRIMARY KEY (id),
	CONSTRAINT fk_id_institucion FOREIGN KEY (id_institucion)
        REFERENCES instituciones (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
	CONSTRAINT fk_id_estudiante FOREIGN KEY (id_estudiante)
        REFERENCES estudiantes (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

CREATE TABLE IF NOT EXISTS public.periodos_academicos
(
    id serial,
    periodo_academico integer,
	anio_periodo_academico integer,
    nombre text,
	id_institucion integer,
    fecha_inicio timestamp(0) without time zone,
    fecha_fin timestamp(0) without time zone,
    created_at timestamp(0) without time zone DEFAULT now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT periodos_academicos_pkey PRIMARY KEY (id),
	CONSTRAINT fk_id_institucion FOREIGN KEY (id_institucion)
        REFERENCES instituciones (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

CREATE TABLE IF NOT EXISTS public.asignaturas
(
    id serial,
	codigo_asignatura text,
    asignatura text,
    detalle text,
	id_institucion integer,
    created_at timestamp(0) without time zone DEFAULT now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT asignaturas_pkey PRIMARY KEY (id),
	CONSTRAINT fk_id_institucion FOREIGN KEY (id_institucion)
        REFERENCES instituciones (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

CREATE TABLE IF NOT EXISTS public.dias_semana 
(
    id SERIAL,
    nombre TEXT NOT NULL,
    abreviatura TEXT NOT NULL,
    created_at timestamp(0) without time zone DEFAULT now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT dias_semana_pkey PRIMARY KEY (id)
);

INSERT INTO dias_semana (nombre, abreviatura) VALUES
('Lunes', 'Lun'),
('Martes', 'Mar'),
('Miércoles', 'Mié'),
('Jueves', 'Jue'),
('Viernes', 'Vie'),
('Sábado', 'Sáb'),
('Domingo', 'Dom');

CREATE TABLE IF NOT EXISTS public.secciones
(
    id serial,
	nombre text,
	aula text,
	id_periodo_academico integer,
    id_asignatura integer,
    hora_inicio time,
	hora_fin time,
    created_at timestamp(0) without time zone DEFAULT now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT secciones_pkey PRIMARY KEY (id),
	CONSTRAINT fk_id_periodos_academicos FOREIGN KEY (id_periodo_academico)
        REFERENCES periodos_academicos (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
	CONSTRAINT fk_id_asignatura FOREIGN KEY (id_asignatura)
        REFERENCES asignaturas (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

CREATE TABLE IF NOT EXISTS public.secciones_estudiantes
(
    id serial,
	id_seccion integer,
	id_estudiante integer,
	observaciones text,
    created_at timestamp(0) without time zone DEFAULT now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT secciones_estudiantes_pkey PRIMARY KEY (id),
	CONSTRAINT fk_id_estudiante FOREIGN KEY (id_estudiante)
        REFERENCES estudiantes (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
	CONSTRAINT fk_id_seccion FOREIGN KEY (id_seccion)
        REFERENCES secciones (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);