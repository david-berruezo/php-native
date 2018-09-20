CREATE TABLE "entityemployee" (
  "individualid" int NOT NULL,
  "organizationid" int NOT NULL,
  CONSTRAINT "fk_entityemployee_individualid"
    FOREIGN KEY ("individualid") REFERENCES "entity"("entityid"),
  CONSTRAINT "fk_entityemployee_organizationid"
    FOREIGN KEY ("organizationid") REFERENCES "entity"("entityid")
);