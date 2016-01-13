CREATE USER applerts WITH PASSWORD applerts;

CREATE DATABASE applerts
 WITH OWNER = applerts
      ENCODING = 'UTF8'
      TABLESPACE = pg_default
      LC_COLLATE = 'en_IN.UTF-8'
      LC_CTYPE = 'en_IN.UTF-8'
      CONNECTION LIMIT = -1;

CREATE SEQUENCE new_table_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 3
  CACHE 1;
ALTER TABLE new_table_id_seq
  OWNER TO applerts;

CREATE TABLE alerts
(
 id integer NOT NULL DEFAULT nextval('new_table_id_seq'::regclass),
 app_name character varying(255),
 email character varying(255),
 is_enabled character varying(255),
 CONSTRAINT new_table_pkey PRIMARY KEY (id)
)
WITH (
 OIDS=FALSE
);
ALTER TABLE alerts
 OWNER TO applerts;

CREATE TABLE applerts_db
(
 app_id character varying NOT NULL DEFAULT 255,
 app_name character varying NOT NULL DEFAULT 255,
 app_user character varying NOT NULL DEFAULT 255,
 app_final_status character varying NOT NULL DEFAULT 255,
 app_type character varying NOT NULL DEFAULT 255,
 app_url text NOT NULL,
 app_start_time timestamp without time zone NOT NULL,
 app_finish_time timestamp without time zone NOT NULL,
 app_elapsed_time bigint NOT NULL,
 app_diagnostics text NOT NULL,
 app_alert_state character varying NOT NULL DEFAULT 255,
 CONSTRAINT applerts_db_pkey PRIMARY KEY (app_id)
)
WITH (
 OIDS=FALSE
);
ALTER TABLE applerts_db
 OWNER TO applerts;


CREATE OR REPLACE VIEW view_report AS
SELECT to_date(applerts_db.app_finish_time::text, 'yyyy-mm-dd'::text) AS rep_date,
   applerts_db.app_final_status, count(*) AS count
  FROM applerts_db
 GROUP BY to_date(applerts_db.app_finish_time::text, 'yyyy-mm-dd'::text), applerts_db.app_final_status;

ALTER TABLE view_report
 OWNER TO applerts;  lerts
WITH OWNER = applerts
ENCODING = 'UTF8'
TABLESPACE = pg_default
LC_COLLATE = 'en_IN.UTF-8'
LC_CTYPE = 'en_IN.UTF-8'
CONNECTION LIMIT = -1;

CREATE TABLE alerts
(
id integer NOT NULL DEFAULT nextval('new_table_id_seq'::regclass),
app_name character varying(255),
email character varying(255),
is_enabled character varying(255),
CONSTRAINT new_table_pkey PRIMARY KEY (id)
)
WITH (
OIDS=FALSE
);
ALTER TABLE alerts
OWNER TO applerts;

CREATE TABLE applerts_db
(
app_id character varying NOT NULL DEFAULT 255,
app_name character varying NOT NULL DEFAULT 255,
app_user character varying NOT NULL DEFAULT 255,
app_final_status character varying NOT NULL DEFAULT 255,
app_type character varying NOT NULL DEFAULT 255,
app_url text NOT NULL,
app_start_time timestamp without time zone NOT NULL,
app_finish_time timestamp without time zone NOT NULL,
app_elapsed_time bigint NOT NULL,
app_diagnostics text NOT NULL,
app_alert_state character varying NOT NULL DEFAULT 255,
CONSTRAINT applerts_db_pkey PRIMARY KEY (app_id)
)
WITH (
OIDS=FALSE
);
ALTER TABLE applerts_db
OWNER TO applerts;


CREATE OR REPLACE VIEW view_report AS
SELECT to_date(applerts_db.app_finish_time::text, 'yyyy-mm-dd'::text) AS rep_date,
applerts_db.app_final_status, count(*) AS count
FROM applerts_db
GROUP BY to_date(applerts_db.app_finish_time::text, 'yyyy-mm-dd'::text), applerts_db.app_final_status;

ALTER TABLE view_report
OWNER TO applerts;