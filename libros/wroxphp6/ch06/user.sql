CREATE TABLE "user" (
"id" SERIAL PRIMARY KEY NOT NULL,
"username" character varying(32),
"password_hash" character varying(32),
"first_name" character varying(64),
"last_name" character varying(64));

GRANT ALL PRIVILEGES ON "user" TO "chaptersix";
GRANT ALL PRIVILEGES ON "user_id_seq" TO "chaptersix";

INSERT INTO "user"("username", "password_hash", "first_name", "last_name") 
  VALUES('ed', md5('berkhamsted'), 'Ed', 'Lecky-Thompson');
INSERT INTO "user"("username", "password_hash", "first_name", "last_name") 
  VALUES('steve', md5('newyork'), 'Steve', 'Nowicki');
INSERT INTO "user"("username", "password_hash", "first_name", "last_name") 
  VALUES('marie', md5('leicester'), 'Marie', 'Ellis');
INSERT INTO "user"("username", "password_hash", "first_name", "last_name")
  VALUES('harriet', md5('cambridge'), 'Harriet', 'Frankland');
