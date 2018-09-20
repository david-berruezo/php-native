CREATE TABLE "subscriber" (
 "id" SERIAL PRIMARY KEY NOT NULL,
 "first_name" character varying (128),
 "last_name" character varying (256),
 "email_address" character varying(256) NOT NULL,
 "date_of_signup" date NOT NULL,
 "time_of_signup" time NOT NULL,
 "remote_addr" character varying(15) NOT NULL
);

GRANT ALL PRIVILEGES ON "subscriber" TO "newsletter";
GRANT ALL PRIVILEGES ON "subscriber_id_seq" TO "newsletter";

CREATE UNIQUE INDEX "em_unq_idx" ON "subscriber"("email_address");
