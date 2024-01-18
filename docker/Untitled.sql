PGDMP     	                     |            postgres     12.16 (Debian 12.16-1.pgdg120+1)    15.4 -    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    13481    postgres    DATABASE     s   CREATE DATABASE postgres WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_US.utf8';
    DROP DATABASE postgres;
                postgres    false            �           0    0    DATABASE postgres    COMMENT     N   COMMENT ON DATABASE postgres IS 'default administrative connection database';
                   postgres    false    3054                        2615    2200    public    SCHEMA     2   -- *not* creating schema, since initdb creates it
 2   -- *not* dropping schema, since initdb creates it
                postgres    false            �           0    0    SCHEMA public    ACL     Q   REVOKE USAGE ON SCHEMA public FROM PUBLIC;
GRANT ALL ON SCHEMA public TO PUBLIC;
                   postgres    false    6            �            1259    16429    posts    TABLE     �  CREATE TABLE public.posts (
    post_id integer NOT NULL,
    forum_type character varying(20) NOT NULL,
    status character varying(20),
    title character varying(255) NOT NULL,
    replies integer DEFAULT 0,
    views integer DEFAULT 0,
    user_id integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    content character varying(5000),
    CONSTRAINT posts_forum_type_check CHECK (((forum_type)::text = ANY ((ARRAY['General'::character varying, 'Experts'::character varying, 'Friends'::character varying])::text[]))),
    CONSTRAINT posts_status_check CHECK (((status)::text = ANY ((ARRAY['pinned'::character varying, 'resolved'::character varying, 'open'::character varying])::text[])))
);
    DROP TABLE public.posts;
       public         heap    postgres    false    6            �            1259    16479 	   all_posts    VIEW     �   CREATE VIEW public.all_posts AS
 SELECT posts.post_id,
    posts.forum_type,
    posts.status,
    posts.title,
    posts.replies,
    posts.views,
    posts.user_id,
    posts.created_at,
    posts.content
   FROM public.posts;
    DROP VIEW public.all_posts;
       public          postgres    false    207    207    207    207    207    207    207    207    207    6            �            1259    16447    post_replies    TABLE     �   CREATE TABLE public.post_replies (
    reply_id integer NOT NULL,
    post_id integer NOT NULL,
    user_id integer NOT NULL,
    content text NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);
     DROP TABLE public.post_replies;
       public         heap    postgres    false    6            �            1259    16445    post_replies_reply_id_seq    SEQUENCE     �   CREATE SEQUENCE public.post_replies_reply_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.post_replies_reply_id_seq;
       public          postgres    false    6    209            �           0    0    post_replies_reply_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.post_replies_reply_id_seq OWNED BY public.post_replies.reply_id;
          public          postgres    false    208            �            1259    16427    posts_post_id_seq    SEQUENCE     �   CREATE SEQUENCE public.posts_post_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.posts_post_id_seq;
       public          postgres    false    6    207            �           0    0    posts_post_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.posts_post_id_seq OWNED BY public.posts.post_id;
          public          postgres    false    206            �            1259    16407    users    TABLE     H  CREATE TABLE public.users (
    id_user integer NOT NULL,
    id_user_details integer,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    enabled boolean DEFAULT true,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    "isAdmin" boolean DEFAULT false NOT NULL
);
    DROP TABLE public.users;
       public         heap    postgres    false    6            �            1259    16396    users_details    TABLE     �   CREATE TABLE public.users_details (
    id_user_details integer NOT NULL,
    name character varying(255),
    profile_image_path character varying(255) DEFAULT 'user0.png'::character varying,
    id_user integer
);
 !   DROP TABLE public.users_details;
       public         heap    postgres    false    6            �            1259    16483    posts_with_user_image    VIEW     r  CREATE VIEW public.posts_with_user_image AS
 SELECT p.post_id,
    p.forum_type,
    p.status,
    p.title,
    p.replies,
    p.views,
    p.user_id,
    p.created_at AS post_created_at,
    p.content,
    ud.profile_image_path
   FROM ((public.posts p
     JOIN public.users u ON ((p.user_id = u.id_user)))
     JOIN public.users_details ud ON ((u.id_user_details = ud.id_user_details)))
  ORDER BY
        CASE
            WHEN ((p.status)::text = 'pinned'::text) THEN 1
            WHEN ((p.status)::text = 'open'::text) THEN 2
            WHEN ((p.status)::text = 'resolved'::text) THEN 3
            ELSE 4
        END;
 (   DROP VIEW public.posts_with_user_image;
       public          postgres    false    207    207    207    207    207    207    207    207    207    203    203    205    205    6            �            1259    16394     user_details_id_user_details_seq    SEQUENCE     �   CREATE SEQUENCE public.user_details_id_user_details_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE public.user_details_id_user_details_seq;
       public          postgres    false    203    6            �           0    0     user_details_id_user_details_seq    SEQUENCE OWNED BY     f   ALTER SEQUENCE public.user_details_id_user_details_seq OWNED BY public.users_details.id_user_details;
          public          postgres    false    202            �            1259    16405    users_id_user_seq    SEQUENCE     �   CREATE SEQUENCE public.users_id_user_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.users_id_user_seq;
       public          postgres    false    205    6            �           0    0    users_id_user_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.users_id_user_seq OWNED BY public.users.id_user;
          public          postgres    false    204            J           2604    16450    post_replies reply_id    DEFAULT     ~   ALTER TABLE ONLY public.post_replies ALTER COLUMN reply_id SET DEFAULT nextval('public.post_replies_reply_id_seq'::regclass);
 D   ALTER TABLE public.post_replies ALTER COLUMN reply_id DROP DEFAULT;
       public          postgres    false    209    208    209            F           2604    16432    posts post_id    DEFAULT     n   ALTER TABLE ONLY public.posts ALTER COLUMN post_id SET DEFAULT nextval('public.posts_post_id_seq'::regclass);
 <   ALTER TABLE public.posts ALTER COLUMN post_id DROP DEFAULT;
       public          postgres    false    206    207    207            B           2604    16410    users id_user    DEFAULT     n   ALTER TABLE ONLY public.users ALTER COLUMN id_user SET DEFAULT nextval('public.users_id_user_seq'::regclass);
 <   ALTER TABLE public.users ALTER COLUMN id_user DROP DEFAULT;
       public          postgres    false    205    204    205            @           2604    16399    users_details id_user_details    DEFAULT     �   ALTER TABLE ONLY public.users_details ALTER COLUMN id_user_details SET DEFAULT nextval('public.user_details_id_user_details_seq'::regclass);
 L   ALTER TABLE public.users_details ALTER COLUMN id_user_details DROP DEFAULT;
       public          postgres    false    203    202    203            �          0    16447    post_replies 
   TABLE DATA           W   COPY public.post_replies (reply_id, post_id, user_id, content, created_at) FROM stdin;
    public          postgres    false    209   �:       �          0    16429    posts 
   TABLE DATA           q   COPY public.posts (post_id, forum_type, status, title, replies, views, user_id, created_at, content) FROM stdin;
    public          postgres    false    207   �>       �          0    16407    users 
   TABLE DATA           j   COPY public.users (id_user, id_user_details, email, password, enabled, created_at, "isAdmin") FROM stdin;
    public          postgres    false    205   �J       �          0    16396    users_details 
   TABLE DATA           [   COPY public.users_details (id_user_details, name, profile_image_path, id_user) FROM stdin;
    public          postgres    false    203   GM       �           0    0    post_replies_reply_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.post_replies_reply_id_seq', 16, true);
          public          postgres    false    208            �           0    0    posts_post_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.posts_post_id_seq', 31, true);
          public          postgres    false    206            �           0    0     user_details_id_user_details_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('public.user_details_id_user_details_seq', 15, true);
          public          postgres    false    202            �           0    0    users_id_user_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.users_id_user_seq', 13, true);
          public          postgres    false    204            [           2606    16456    post_replies post_replies_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.post_replies
    ADD CONSTRAINT post_replies_pkey PRIMARY KEY (reply_id);
 H   ALTER TABLE ONLY public.post_replies DROP CONSTRAINT post_replies_pkey;
       public            postgres    false    209            Y           2606    16439    posts posts_pkey 
   CONSTRAINT     S   ALTER TABLE ONLY public.posts
    ADD CONSTRAINT posts_pkey PRIMARY KEY (post_id);
 :   ALTER TABLE ONLY public.posts DROP CONSTRAINT posts_pkey;
       public            postgres    false    207            O           2606    16404    users_details user_details_pkey 
   CONSTRAINT     j   ALTER TABLE ONLY public.users_details
    ADD CONSTRAINT user_details_pkey PRIMARY KEY (id_user_details);
 I   ALTER TABLE ONLY public.users_details DROP CONSTRAINT user_details_pkey;
       public            postgres    false    203            Q           2606    16468 '   users_details users_details_user_id_key 
   CONSTRAINT     e   ALTER TABLE ONLY public.users_details
    ADD CONSTRAINT users_details_user_id_key UNIQUE (id_user);
 Q   ALTER TABLE ONLY public.users_details DROP CONSTRAINT users_details_user_id_key;
       public            postgres    false    203            S           2606    16421    users users_email_key 
   CONSTRAINT     Q   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);
 ?   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_key;
       public            postgres    false    205            U           2606    16419    users users_id_user_details_key 
   CONSTRAINT     e   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_id_user_details_key UNIQUE (id_user_details);
 I   ALTER TABLE ONLY public.users DROP CONSTRAINT users_id_user_details_key;
       public            postgres    false    205            W           2606    16417    users users_pkey 
   CONSTRAINT     S   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id_user);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public            postgres    false    205            \           2606    16469 %   users_details fk_user_details_user_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.users_details
    ADD CONSTRAINT fk_user_details_user_id FOREIGN KEY (id_user) REFERENCES public.users(id_user) ON DELETE CASCADE;
 O   ALTER TABLE ONLY public.users_details DROP CONSTRAINT fk_user_details_user_id;
       public          postgres    false    2903    203    205            _           2606    16457 &   post_replies post_replies_post_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.post_replies
    ADD CONSTRAINT post_replies_post_id_fkey FOREIGN KEY (post_id) REFERENCES public.posts(post_id) ON DELETE CASCADE;
 P   ALTER TABLE ONLY public.post_replies DROP CONSTRAINT post_replies_post_id_fkey;
       public          postgres    false    207    2905    209            `           2606    16462 &   post_replies post_replies_user_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.post_replies
    ADD CONSTRAINT post_replies_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id_user) ON DELETE CASCADE;
 P   ALTER TABLE ONLY public.post_replies DROP CONSTRAINT post_replies_user_id_fkey;
       public          postgres    false    205    209    2903            ^           2606    16440    posts posts_user_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.posts
    ADD CONSTRAINT posts_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id_user) ON DELETE CASCADE;
 B   ALTER TABLE ONLY public.posts DROP CONSTRAINT posts_user_id_fkey;
       public          postgres    false    205    207    2903            ]           2606    16422     users users_id_user_details_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_id_user_details_fkey FOREIGN KEY (id_user_details) REFERENCES public.users_details(id_user_details) ON DELETE CASCADE;
 J   ALTER TABLE ONLY public.users DROP CONSTRAINT users_id_user_details_fkey;
       public          postgres    false    2895    205    203            �   �  x��U�n�6>[O1q�=E�~mɉ�X��"���m{	PP�Xb,�I�Q��)�*{lޫC)�"�Eуΐ�8�7?�,�|�^|/��а���s���n;T极��Xq|�r�o�"��#?ZCo��6\i�%���g��>��?�×G0A�؋����hV���5bI�i���@�ŧ�ر㢁R��C�j8ai�E8����8ن�6)�"-�,���R]���Y�+%��ZvD�/W��qt?:�N�F]�pZVv��5��2ZB�]�X]S`϶Q�z�]и[�xm�m��n9��K[�z|4����Ϊ�������/|d�o �� �/ �|&Dk'��b�#_�=	6QV�2���������}���{���%�`��-I]햭��lW+�{���! ��[���V���F��;�Sή�JvR���w�گ:i��ߠ@�,?����Q�gi��Y���yo�=��������9�u�v?DA��xS�Q��&���:�{�3�]���-���(�r�g^/�b�;�>jdv��3��	֍�!�k�-��#�mQS���n�eB�,���&�k��0N���ֵ��A�ӌX���u �Z&�<����N�Y7Lm�����g�����8I�0\�I�E�cF�K�~�s�E|@Q9�E������H8Q�-�Z�w� ��^��	j{���1�g�t�4����be�5���Jj4�pjyՒ<��V�r���@
�u��0�k�5����,�$���N��B�ăQ�~�n�r�Y��"eb��E)�ڢ�D��o����#�H3s��=�yr���p=�E�K��l��f��'N�q{hM|�Q��>Q�}C5dhA�,���<�Y{Q���9�5�.����S�sv��NB����9%w�E�XAHtZ�5"''<U#���r����ׁ��Z�j�jR]N=@���[�X�I$�&Q���4ɽ����ST�      �     x��Y�n�F}����6	0k.�X6ر��agm,����Ӛ&��&5�����q����jr.��N�H,�#�.�NU�n��`*�;򵩎~ַ����jiClT�cst��Ώ�'����Ƀ�\MO.'�������|>?*�QW��Z���zy��j]_������fb�lg�TM]�f�'g�����bx:�Uc���ѡ���^��)}��
F;լlU�o�7<�\�..g����t29z�K���r_"�dc��&O������^���XݴA�Rg��~�w��g~g�Ww
 X������:G*��U�V�z�^���Gv��S�{9��/��͏���M?��h|�]e����3u��ʪ��@�
_*���R�\~�Ɠ����.o��'��p�eqO'����2�����K�ֆ�����m:	}r���\��\�L.�'������4�27&t�2#u��Qc*�&ga�·�^t~��̔�jD���k՘lUy�H�j�7�6`a�2ť%-Z�����n�����J7̸�P`�6�9�_��m��j�8��*��X%��O���
]�L�"�߁w�;�ƻ���G0@	O�'g����K���9_��r�H�*6�-
��7�Y�$��S7�0�^���%� L]��xQwʧ���iթ��Q����ĉ)��Z�f�s�FLV%���6��)�S���̓�6�F=�%[	���k���&�L4���x2���WNWSDR;��P,qp`���9�.��7)�`2_�y�/g4&��c|��9+L���0�gD�/Գ`L��<�uhH<���A$Mk~:>?��>:cQ�s����K,�����bz��=~��*vaAv�lE�1��*���KX7cBL�Zg�ɜ&�b�4Yc��KN�w(+ �'g���xv29��#ߊ��*s>�|tPF`��7�Uu�2$��"��OX�V��[[3���j�:�	�>��m�|�����`a���,x��������|�2�&t=���|�}�Ɯ�7;�%i�����D�����,��I���� ��6r8�����P�*��odp��MC�>�Ü{lzrq>K9�#`���1̵m�U��(�Z�fk��)V�^m^�k���lK0�Y�n�:�m�s���jkt��h�΂��ݘ<�y3�t&���Eg0�P�x�vU�}�Y�y����\>z���>��wN/Ɠ������c	����-�&^��\�\����7���s�K�rZ"m:� ���>`g���h)�������
{���m��v`�p����L����le��>쾵����%�����%g���]�"A��8Rf%�Z�r���4���Fi�aP*S���+�MFA���
�;�C��6j�je]��6�8p��5��#?���߽bT�,���u��`Yt�x��x��"2�v �)[L�m*���􇬠 ���b��xr�m�S�(�$�����+& �����Y���d�14�����yUX��
aS`�cMfpd���*\�.md�U�f�1���� l���"����m���L����ۜ#J2`��ne��!��PB b�@�C'5\�TK��J�3@��-m'�J���N2�G�	{���|�5�ոGHQ���).�lg�AF�X���Ԃ��(���`�����<n��v��t��R�a:��[�b�"���E�aR'x���~n�}�����+��%����{�N���!�0��Ұ��IL���i�}�b��(l�:�\meo��/U�N��oo�H�4BgЅwX����O��V�����d�X �9��M����c���,����sh�m�}��a<a����!�1����8{�m��EW�>8'���"����7<���T��C�uU��x�s{4�4<�`3~�q"�T��=��ͽ�ii"�7�� 0l1�������2il?_J!�0G���2�n�+�|��ڪ��F6���K-��٥��"�k����,�?x젠	�n�,���(��B����2ޯx�һ]jn���s�s-|>�M@���I��-��	���^�V�6��7�ue�-La��������8�v�7�!��@k��!Ǡ�s�)4�);�}�ߝ4t�v�r�p� q�Ӕ��u_Ow�5"�n��6:��N�h�+��y/՛��_"�12.����+��� �� yǳ�s�����<a#U�7�ډ���K��f��a��zg\Fa����Ƭ�Q���(��C�i�og�P79a��I�XJ�_�W�*mfIu�"�_P7V��ERgع���WN����c<�T�����s��1bh��ų����lY}����s��x��a���%{pN�<�_��:p�W�xY X��z�n����g�f�_����"bY���̅��Ę�M���1r�OL�O���~���<C7�<Q��]h�09D��p 8�	���rr��s��N.��N�~:t<w�6g�43$��mx)ӻ�8�`����}*T#U�](O��h�i�x�y%��܎��#�e\¨A�{2���2�R%���������$*�:~c>�����0 �L�޴(r���yC2,�b%��~0��~-�˽����b̠'v*v�����:��e���#z�)�pI2�ibU�����d.�Ǹ=&ɭ�m$M���]����jW�TD�x�"�Z�ԥ.��cܘ?S(N�<��p�v*u
�hB�|�тp��řS�D���8>�P?f�)q܇�g��E��+*{'�H���s=��W�Jjn��H��X�aA8���a~E�ҁWV5���m}H���E��!7]3~��c�6Y�7]�����
��,f�i��.�6�>N�As���z�K����2���3}��!!�0x@�����v	%��rD��vB�G���#>�N���JY�y��@���>ym
�"�+���u/q�ڇ����H&�x�uJ�bP9�t�u���k�nO���/p�#9�L�Ԏq�5��pPV��.��g�h�~hL�8��2��������������T      �   c  x�e�Is�P��5��,����WĠ�D�Vo ��2(�}cwuU�Ug����A�I��2�[�{I�2g^q������U������Ɨw#ݮ�m��?��a�=�-�/�|�S�~E��4����/$�@I���	@�E"r�i$31MX7e�?���6��Mu�\��<=L�ηr}Ԫ�oQn�ɉ�3G��Hb� �p��;)2��$�gsu��E�-]��Gr��V[L�s�c!��hލ��bIm|-X�O�o&_0R��@0�x��H�Im���\"�&ZH�z�rc�.	�U�
��^5��O��xcX��|h���H�aV���1��4�����yą�ք}Y|�����Z��b�5g�<�@!-`Q�.[[�p�w�X8���y3i��Ǿ�*+��*�<AC��PD�ܫ���YR����k=9w�<�6�ϵ�Ɨ:������t[7�|�έm�Q?�❆P� �������`g�Q_̋�u�}At0�k�l�̡�ų�����pWQ�;`���&���^T��@`�8��ÄA<�y���)ِI�9=�Wvٙf"�S�ʈ:?�K�,W���b��Ǜw�4����,+e������}��      �   �   x�M��
�@E뙯���<�L��*�J3��Y]weU~}�����R9۠pF:�G�Q8�R$���SpS��v:�Sx����f��--�K�L]�o�vh����S�6Ү!�sf�W�J�ޖ�����~�)�����-���A��&��_.�ww��~�t���1%�
���Ia     