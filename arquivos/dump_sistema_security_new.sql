--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.2
-- Dumped by pg_dump version 9.5.1

-- Started on 2016-08-02 23:06:17

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 2154 (class 1262 OID 16393)
-- Name: sistema; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE sistema WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Portuguese_Brazil.1252' LC_CTYPE = 'Portuguese_Brazil.1252';


ALTER DATABASE sistema OWNER TO postgres;

\connect sistema

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 8 (class 2615 OID 68676326)
-- Name: security; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA security;


ALTER SCHEMA security OWNER TO postgres;

--
-- TOC entry 1 (class 3079 OID 12355)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2157 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = security, pg_catalog;

--
-- TOC entry 182 (class 1259 OID 68676327)
-- Name: privilege_id_seq; Type: SEQUENCE; Schema: security; Owner: postgres
--

CREATE SEQUENCE privilege_id_seq
    START WITH 7
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE privilege_id_seq OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 186 (class 1259 OID 68676335)
-- Name: privilege; Type: TABLE; Schema: security; Owner: postgres
--

CREATE TABLE privilege (
    id bigint DEFAULT nextval('privilege_id_seq'::regclass) NOT NULL,
    role_id bigint NOT NULL,
    resource_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    created_at timestamp(6) without time zone DEFAULT '2016-05-09 19:49:20.303619'::timestamp without time zone NOT NULL,
    updated_at timestamp(6) without time zone DEFAULT '2016-05-09 19:49:20.312154'::timestamp without time zone NOT NULL
);


ALTER TABLE privilege OWNER TO postgres;

--
-- TOC entry 183 (class 1259 OID 68676329)
-- Name: resource_id_seq; Type: SEQUENCE; Schema: security; Owner: postgres
--

CREATE SEQUENCE resource_id_seq
    START WITH 13
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE resource_id_seq OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 68676341)
-- Name: resource; Type: TABLE; Schema: security; Owner: postgres
--

CREATE TABLE resource (
    id bigint DEFAULT nextval('resource_id_seq'::regclass) NOT NULL,
    name character varying(255) NOT NULL,
    created_at timestamp(6) without time zone DEFAULT '2016-05-09 19:49:20.320868'::timestamp without time zone NOT NULL,
    updated_at timestamp(6) without time zone DEFAULT '2016-05-09 19:49:20.329822'::timestamp without time zone NOT NULL
);


ALTER TABLE resource OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 68676331)
-- Name: role_id_seq; Type: SEQUENCE; Schema: security; Owner: postgres
--

CREATE SEQUENCE role_id_seq
    START WITH 14
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE role_id_seq OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 68676347)
-- Name: role; Type: TABLE; Schema: security; Owner: postgres
--

CREATE TABLE role (
    id bigint DEFAULT nextval('role_id_seq'::regclass) NOT NULL,
    parent_id bigint,
    name character varying(255) NOT NULL,
    is_admin smallint DEFAULT 0 NOT NULL,
    created_at timestamp(6) without time zone DEFAULT '2016-05-09 19:49:20.286659'::timestamp without time zone NOT NULL,
    updated_at timestamp(6) without time zone DEFAULT '2016-05-09 19:49:20.294927'::timestamp without time zone NOT NULL
);


ALTER TABLE role OWNER TO postgres;

--
-- TOC entry 185 (class 1259 OID 68676333)
-- Name: user_id_seq; Type: SEQUENCE; Schema: security; Owner: postgres
--

CREATE SEQUENCE user_id_seq
    START WITH 101
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE user_id_seq OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 68676354)
-- Name: user; Type: TABLE; Schema: security; Owner: postgres
--

CREATE TABLE "user" (
    id bigint DEFAULT nextval('user_id_seq'::regclass) NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(30) NOT NULL,
    salt character varying NOT NULL,
    active smallint DEFAULT 0 NOT NULL,
    activation_key character varying,
    created_at timestamp(6) without time zone DEFAULT '2016-05-09 19:49:20.259'::timestamp without time zone NOT NULL,
    updated_at timestamp(6) without time zone DEFAULT '2016-05-09 19:49:20.273266'::timestamp without time zone NOT NULL,
    role_id bigint DEFAULT 1 NOT NULL
);


ALTER TABLE "user" OWNER TO postgres;

--
-- TOC entry 2158 (class 0 OID 0)
-- Dependencies: 189
-- Name: COLUMN "user".active; Type: COMMENT; Schema: security; Owner: postgres
--

COMMENT ON COLUMN "user".active IS '1=ativo 0=inativo / true-false';


--
-- TOC entry 2146 (class 0 OID 68676335)
-- Dependencies: 186
-- Data for Name: privilege; Type: TABLE DATA; Schema: security; Owner: postgres
--

INSERT INTO privilege VALUES (4, 1, 7, 'indexAction', '2016-05-09 22:15:11', '2016-05-09 22:15:11');
INSERT INTO privilege VALUES (5, 1, 6, 'indexAction', '2016-05-10 22:24:03', '2016-05-10 22:24:03');
INSERT INTO privilege VALUES (7, 1, 6, 'testeAction', '2016-05-15 20:17:38', '2016-05-15 20:17:38');


--
-- TOC entry 2159 (class 0 OID 0)
-- Dependencies: 182
-- Name: privilege_id_seq; Type: SEQUENCE SET; Schema: security; Owner: postgres
--

SELECT pg_catalog.setval('privilege_id_seq', 7, true);


--
-- TOC entry 2147 (class 0 OID 68676341)
-- Dependencies: 187
-- Data for Name: resource; Type: TABLE DATA; Schema: security; Owner: postgres
--

INSERT INTO resource VALUES (6, 'IndexController', '2016-05-08 16:11:34.139013', '2016-05-08 16:11:34.139013');
INSERT INTO resource VALUES (7, 'UserController', '2016-05-08 16:11:34.139013', '2016-05-08 16:11:34.139013');
INSERT INTO resource VALUES (8, 'RoleController', '2016-05-08 16:11:34.139013', '2016-05-08 16:11:34.139013');
INSERT INTO resource VALUES (9, 'ResourceController', '2016-05-08 16:11:34.139013', '2016-05-08 16:11:34.139013');
INSERT INTO resource VALUES (10, 'PrivilegeController', '2016-05-08 16:11:34.139013', '2016-05-08 16:11:34.139013');


--
-- TOC entry 2160 (class 0 OID 0)
-- Dependencies: 183
-- Name: resource_id_seq; Type: SEQUENCE SET; Schema: security; Owner: postgres
--

SELECT pg_catalog.setval('resource_id_seq', 13, true);


--
-- TOC entry 2148 (class 0 OID 68676347)
-- Dependencies: 188
-- Data for Name: role; Type: TABLE DATA; Schema: security; Owner: postgres
--

INSERT INTO role VALUES (1, NULL, 'Usuario', 0, '2016-05-08 16:11:33.688886', '2016-05-14 13:03:55');
INSERT INTO role VALUES (2, NULL, 'Administrador', 1, '2016-05-08 16:11:33.688886', '2016-05-08 16:11:33.688886');


--
-- TOC entry 2161 (class 0 OID 0)
-- Dependencies: 184
-- Name: role_id_seq; Type: SEQUENCE SET; Schema: security; Owner: postgres
--

SELECT pg_catalog.setval('role_id_seq', 14, true);


--
-- TOC entry 2149 (class 0 OID 68676354)
-- Dependencies: 189
-- Data for Name: user; Type: TABLE DATA; Schema: security; Owner: postgres
--

INSERT INTO "user" VALUES (86, 'Luiz E Souza Aranda', 'luizeduardotk@gmail.com', 'uuRkPlMba0vy/A+n', 'd3xdgUvOHzU=', 1, 'cf3a3b357a6d174b77d3880ed5468a21', '2016-05-05 20:26:31', '2016-05-08 17:15:08', 2);


--
-- TOC entry 2162 (class 0 OID 0)
-- Dependencies: 185
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: security; Owner: postgres
--

SELECT pg_catalog.setval('user_id_seq', 102, true);


--
-- TOC entry 2017 (class 2606 OID 68676366)
-- Name: privilege_pkey; Type: CONSTRAINT; Schema: security; Owner: postgres
--

ALTER TABLE ONLY privilege
    ADD CONSTRAINT privilege_pkey PRIMARY KEY (id);


--
-- TOC entry 2019 (class 2606 OID 68676368)
-- Name: resource_pkey; Type: CONSTRAINT; Schema: security; Owner: postgres
--

ALTER TABLE ONLY resource
    ADD CONSTRAINT resource_pkey PRIMARY KEY (id);


--
-- TOC entry 2021 (class 2606 OID 68676370)
-- Name: role_pkey; Type: CONSTRAINT; Schema: security; Owner: postgres
--

ALTER TABLE ONLY role
    ADD CONSTRAINT role_pkey PRIMARY KEY (id);


--
-- TOC entry 2023 (class 2606 OID 68676372)
-- Name: user_pkey; Type: CONSTRAINT; Schema: security; Owner: postgres
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- TOC entry 2025 (class 2606 OID 68676378)
-- Name: privilege_resource_id_fkey; Type: FK CONSTRAINT; Schema: security; Owner: postgres
--

ALTER TABLE ONLY privilege
    ADD CONSTRAINT privilege_resource_id_fkey FOREIGN KEY (resource_id) REFERENCES resource(id);


--
-- TOC entry 2024 (class 2606 OID 68676373)
-- Name: privilege_role_id_fkey; Type: FK CONSTRAINT; Schema: security; Owner: postgres
--

ALTER TABLE ONLY privilege
    ADD CONSTRAINT privilege_role_id_fkey FOREIGN KEY (role_id) REFERENCES role(id);


--
-- TOC entry 2026 (class 2606 OID 68676383)
-- Name: role_parent_id_fkey; Type: FK CONSTRAINT; Schema: security; Owner: postgres
--

ALTER TABLE ONLY role
    ADD CONSTRAINT role_parent_id_fkey FOREIGN KEY (parent_id) REFERENCES role(id);


--
-- TOC entry 2027 (class 2606 OID 68676388)
-- Name: user_role_id_fkey; Type: FK CONSTRAINT; Schema: security; Owner: postgres
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_role_id_fkey FOREIGN KEY (role_id) REFERENCES role(id);


--
-- TOC entry 2156 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2016-08-02 23:06:18

--
-- PostgreSQL database dump complete
--

