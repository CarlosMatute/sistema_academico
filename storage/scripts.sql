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
    id integer NOT NULL DEFAULT nextval('instituciones_id_seq'::regclass),
    nombre text COLLATE pg_catalog."default",
    siglas text COLLATE pg_catalog."default",
    campus text COLLATE pg_catalog."default",
    detalles text COLLATE pg_catalog."default",
    created_at timestamp(0) without time zone DEFAULT now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT instituciones_pkey PRIMARY KEY (id)
);