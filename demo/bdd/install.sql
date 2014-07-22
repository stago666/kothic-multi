CREATE TABLE "DD_Character" (
  idCharacter   SERIAL,
  owner         VARCHAR(255)    NOT NULL,
  name          VARCHAR(255)    NOT NULL,
  level         INTEGER         NOT NULL    DEFAULT 1,
  experience    INTEGER         NOT NULL    DEFAULT 0,
  genre         VARCHAR(1)      NOT NULL,
  size          INTEGER         NOT NULL,
  weight        INTEGER         NOT NULL,
  age           INTEGER         NOT NULL,
  alignment     VARCHAR(30)     NOT NULL,
  idRace        INTEGER         NOT NULL,
  idClasse      INTEGER         NOT NULL,
  idGod         INTEGER         NOT NULL
);

CREATE TABLE "DD_Race" (
  idRace        SERIAL,
  name          VARCHAR(255)    UNIQUE NOT NULL,
  description   TEXT,
  sizeCategory  VARCHAR(5)      NOT NULL,
  sizeMin       INTEGER         NOT NULL,
  sizeMax       INTEGER         NOT NULL,
  weightMin     INTEGER         NOT NULL,
  weightMax     INTEGER         NOT NULL,
  speed         INTEGER         NOT NULL,
  vision        VARCHAR(30)     NOT NULL,
  numLanguage   INTEGER         NOT NULL
);

CREATE TABLE "DD_Classe" (
  idClasse      SERIAL,
  name          VARCHAR(255)    UNIQUE NOT NULL,
  description   TEXT,
  role          VARCHAR(30)     NOT NULL,
  power         VARCHAR(30)     NOT NULL,
  life          INTEGER         NOT NULL,
  lifeAttr      INTEGER,
  lifeStep      INTEGER         NOT NULL,
  recovery      INTEGER         NOT NULL,
  recoveryAttr  INTEGER,
  numAbility    INTEGER
);

CREATE TABLE "DD_Attribute" (
  idAttribute   SERIAL,
  name          VARCHAR(255)    UNIQUE NOT NULL,
  shortName     VARCHAR(10)
);

CREATE TABLE "DD_Ability" (
  idAbility     SERIAL,
  name          VARCHAR(255)    UNIQUE NOT NULL,
  description   TEXT,
  idAttribute   INTEGER
);

CREATE TABLE "DD_Defence" (
  idDefence     SERIAL,
  name          VARCHAR(255)    UNIQUE NOT NULL,
  shortName     VARCHAR(10),
  description   TEXT
);

CREATE TABLE "DD_Language" (
  idLanguage    SERIAL,
  name          VARCHAR(255)    UNIQUE NOT NULL,
  description   TEXT
);

CREATE TABLE "DD_God" (
  idGod         SERIAL,
  name          VARCHAR(255)    UNIQUE NOT NULL,
  description   TEXT            NOT NULL
);

CREATE TABLE "DD_Modifier" (
  idModifier    SERIAL,
  sourcetable   VARCHAR(255)    NOT NULL, --- Qui est concerné (Classe/Race/Personnage/Talent)
  sourceid      INTEGER         NOT NULL,
  targettable   VARCHAR(255)    NOT NULL, --- Ce qui est concerné (Attribut/Abilité/Attaque/Dégât/etc)
  targetid      INTEGER         NOT NULL,
  targetfield   VARCHAR(255),
  modifier      INTEGER         NOT NULL    DEFAULT 0
);

CREATE TABLE "DD_Required" (
  idRequired    SERIAL,
  reqtable      VARCHAR(255)    NOT NULL,
  reqid         INTEGER,
  reqfield      VARCHAR(255),
  reqValue      INTEGER,
  reqContent    VARCHAR(255)
);

CREATE TABLE "DD_Perk" (
  idPerk        SERIAL,
  type          VARCHAR(25)     NOT NULL,
  name          VARCHAR(255)    UNIQUE NOT NULL,
  description   TEXT            NOT NULL
);

CREATE TABLE "DD_Skill" (
  idSkill       SERIAL,
  name          VARCHAR(255)    NOT NULL,
  level         INTEGER         NOT NULL,
  categorie     VARCHAR(100)    NOT NULL,
  type          VARCHAR(100)    NOT NULL,
  keywords      VARCHAR(255),
  action        VARCHAR(100),
  range         VARCHAR(255),
  target        VARCHAR(255),
  attaque       INTEGER,
  defence       INTEGER,
  description   TEXT            NOT NULL
);

CREATE TABLE "DD_Weapon" (
  idWeapon      SERIAL,
  name          VARCHAR(255)    UNIQUE NOT NULL,
  category      VARCHAR(100)    NOT NULL,         --- (1 seul) simple/guerre/superieur/improvise
  type          VARCHAR(255)    NOT NULL,         --- (1 seul) corps à corps / distance
  group         VARCHAR(100)    NOT NULL,         --- (1 ou plusieurs) Marteaux / Lames légères / Lames lourdes
  weight        INTEGER         NOT NULL,
  minRange      INTEGER,
  maxRange      INTEGER,
  handling      INTEGER         NOT NULL,
  damage        VARCHAR(15)     NOT NULL
);

CREATE TABLE "DD_WGroup" (
  idWGroup      SERIAL,
  name          VARCHAR(255)    UNIQUE NOT NULL,
  description   TEXT
);

CREATE TABLE "DD_WAttribute" (
  idWAttribute  SERIAL,
  name          VARCHAR(255)    UNIQUE NOT NULL,
  description   TEXT            NOT NULL
);

CREATE TABLE "DD_CharacterAttribute" (
  idCharacter   INTEGER         NOT NULL,
  idAttribute   INTEGER         NOT NULL,
  value         INTEGER         NOT NULL    DEFAULT 10
);

CREATE TABLE "DD_CharacterAbility" (
  idCharacter   INTEGER         NOT NULL,
  idAbility     INTEGER         NOT NULL
);

CREATE TABLE "DD_CharacterDefence" (
  idCharacter   INTEGER         NOT NULL,
  idDefence     INTEGER         NOT NULL
);

CREATE TABLE "DD_CharacterPerk" (
  idCharacter   INTEGER         NOT NULL,
  idPerk        INTEGER         NOT NULL
);

CREATE TABLE "DD_CharacterSkill" (
  idCharacter   INTEGER         NOT NULL,
  idSkill       INTEGER         NOT NULL
);

CREATE TABLE "DD_RaceAttributeBonus" (
  idRace        INTEGER         NOT NULL,
  idAttribute   INTEGER         NOT NULL,
  value         INTEGER         NOT NULL    DEFAULT 0
);

CREATE TABLE "DD_RaceAbilityBonus" (
  idRace        INTEGER         NOT NULL,
  idAbility     INTEGER         NOT NULL,
  value         INTEGER         NOT NULL    DEFAULT 0
);

CREATE TABLE "DD_RaceLanguage" (
  idRace        INTEGER         NOT NULL,
  idLanguage    INTEGER         NOT NULL
);

CREATE TABLE "DD_RacePerk" (
  idRace        INTEGER         NOT NULL,
  idPerk        INTEGER         NOT NULL
);

CREATE TABLE "DD_ClasseAttribute" (
  idClasse      INTEGER         NOT NULL,
  idAttribute   INTEGER         NOT NULL
);

CREATE TABLE "DD_ClasseAbilityForm" (
  idClasse      INTEGER         NOT NULL,
  idAbility     INTEGER         NOT NULL,
  autoForm      BOOLEAN         NOT NULL    DEFAULT FALSE
);

CREATE TABLE "DD_ClasseDefenceBonus" (
  idClasse      INTEGER         NOT NULL,
  idDefence     INTEGER         NOT NULL,
  value         INTEGER         NOT NULL    DEFAULT 0
);

CREATE TABLE "DD_ClassePerk" (
  idClasse      INTEGER         NOT NULL,
  idPerk        INTEGER         NOT NULL
);

CREATE TABLE "DD_DefenceAttribute" (
  idDefence     INTEGER         NOT NULL,
  idAttribute   INTEGER         NOT NULL
);

CREATE TABLE "DD_ModifierRequired" (
  idModifier    INTEGER         NOT NULL,
  idRequired    INTEGER         NOT NULL
);

CREATE TABLE "DD_PerkRequired" (
  idPerk        INTEGER         NOT NULL,
  idRequired    INTEGER         NOT NULL
);

CREATE TABLE "DD_PerkModifier" (
  idPerk        INTEGER         NOT NULL,
  idModifier    INTEGER         NOT NULL
);

CREATE TABLE "DD_PerkSkill" (
  idPerk        INTEGER         NOT NULL,
  idSkill       INTEGER         NOT NULL
);

CREATE TABLE "DD_WeaponsGroup" (
  idWeapon      INTEGER         NOT NULL,
  idWGroup      INTEGER         NOT NULL
);

CREATE TABLE "DD_WeaponsAttribute" (
  idWeapon      INTEGER         NOT NULL,
  idWAttribute  INTEGER         NOT NULL
);

------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------

ALTER TABLE "DD_Character"
  ADD CONSTRAINT pkCharacter PRIMARY KEY (idCharacter),
  ADD CONSTRAINT fkCharacterRace FOREIGN KEY (idRace) REFERENCES "DD_Race"(idRace),
  ADD CONSTRAINT fkCharacterClasse FOREIGN KEY (idClasse) REFERENCES "DD_Classe"(idClasse),
  ADD CONSTRAINT fkCharacterGod FOREIGN KEY (idGod) REFERENCES "DD_God"(idGod);

ALTER TABLE "DD_Race"
  ADD CONSTRAINT pkRace PRIMARY KEY (idRace);

ALTER TABLE "DD_Classe"
  ADD CONSTRAINT pkClasse PRIMARY KEY (idClasse),
  ADD CONSTRAINT fkClasseLife FOREIGN KEY (lifeAttr) REFERENCES "DD_Attribute"(idAttribute),
  ADD CONSTRAINT fkClasseRecovery FOREIGN KEY (recoveryAttr) REFERENCES "DD_Attribute"(idAttribute);

ALTER TABLE "DD_Attribute"
  ADD CONSTRAINT pkAttribute PRIMARY KEY (idAttribute);

ALTER TABLE "DD_Ability"
  ADD CONSTRAINT pkAbility PRIMARY KEY (idAttribute),
  ADD CONSTRAINT fkAbilityAttribute FOREIGN KEY (idAttribute) REFERENCES "DD_Attribute"(idAttribute);

ALTER TABLE "DD_Defence"
  ADD CONSTRAINT pkDefence PRIMARY KEY (idDefence);

ALTER TABLE "DD_Language"
  ADD CONSTRAINT pkLanguage PRIMARY KEY (idLanguage);

ALTER TABLE "DD_God"
  ADD CONSTRAINT pkGod PRIMARY KEY (idGod);

ALTER TABLE "DD_Required"
  ADD CONSTRAINT pkRequired PRIMARY KEY (idRequired);

ALTER TABLE "DD_Modifier"
  ADD CONSTRAINT pkModifier PRIMARY KEY (idModifier);

ALTER TABLE "DD_CharacterAttribute"
  ADD CONSTRAINT pkCharacterAttribute PRIMARY KEY (idCharacter,idAttribute),
  ADD CONSTRAINT fkCharacterAttributeCharacter FOREIGN KEY (idCharacter) REFERENCES "DD_Character"(idCharacter),
  ADD CONSTRAINT fkCharacterAttributeAttribute FOREIGN KEY (idAttribute) REFERENCES "DD_Attribute"(idAttribute);

ALTER TABLE "DD_CharacterAbility"
  ADD CONSTRAINT pkCharacterAbility PRIMARY KEY (idCharacter,idAbility),
  ADD CONSTRAINT fkCharacterAbilityCharacter FOREIGN KEY (idCharacter) REFERENCES "DD_Character"(idCharacter),
  ADD CONSTRAINT fkCharacterAbilityAbility FOREIGN KEY (idAbility) REFERENCES "DD_Ability"(idAbility);

ALTER TABLE "DD_CharacterDefence"
  ADD CONSTRAINT pkCharacterDefence PRIMARY KEY (idCharacter,idDefence),
  ADD CONSTRAINT fkCharacterDefenceCharacter FOREIGN KEY (idCharacter) REFERENCES "DD_Character"(idCharacter),
  ADD CONSTRAINT fkCharacterDefenceDefence FOREIGN KEY (idDefence) REFERENCES "DD_Defence"(idDefence);

ALTER TABLE "DD_CharacterPerk"
  ADD CONSTRAINT pkCharacterPerk PRIMARY KEY (idCharacter,idPerk),
  ADD CONSTRAINT fkCharacterPerkCharacter FOREIGN KEY (idCharacter) REFERENCES "DD_Character"(idCharacter),
  ADD CONSTRAINT fkCharacterPerkPerk FOREIGN KEY (idPerk) REFERENCES "DD_Perk"(idPerk);

ALTER TABLE "DD_CharacterSkill"
  ADD CONSTRAINT pkCharacterSkill PRIMARY KEY (idCharacter,idSkill),
  ADD CONSTRAINT fkCharacterSkillCharacter FOREIGN KEY (idCharacter) REFERENCES "DD_Character"(idCharacter),
  ADD CONSTRAINT fkCharacterSkillSkill FOREIGN KEY (idSkill) REFERENCES "DD_Skill"(idSkill);

ALTER TABLE "DD_RaceAttributeBonus"
  ADD CONSTRAINT pkRaceAttributeBonus PRIMARY KEY (idRace,idAttribute),
  ADD CONSTRAINT fkRaceAttributeBonusRace FOREIGN KEY (idRace) REFERENCES "DD_Race"(idRace),
  ADD CONSTRAINT fkRaceAttributeBonusAttribute FOREIGN KEY (idAttribute) REFERENCES "DD_Attribute"(idAttribute);

ALTER TABLE "DD_RaceAbilityBonus"
  ADD CONSTRAINT pkRaceAbilityBonus PRIMARY KEY (idRace,idAbility),
  ADD CONSTRAINT fkRaceAbilityBonusRace FOREIGN KEY (idRace) REFERENCES "DD_Race"(idRace),
  ADD CONSTRAINT fkRaceAbilityBonusAbility FOREIGN KEY (idAbility) REFERENCES "DD_Ability"(idAbility);

ALTER TABLE "DD_RaceLanguage"
  ADD CONSTRAINT pkRaceLanguage PRIMARY KEY (idRace,idLanguage),
  ADD CONSTRAINT fkRaceLanguageRace FOREIGN KEY (idRace) REFERENCES "DD_Race"(idRace),
  ADD CONSTRAINT fkRaceLanguageLanguage FOREIGN KEY (idLanguage) REFERENCES "DD_Language"(idLanguage);

ALTER TABLE "DD_RacePerk"
  ADD CONSTRAINT pkRacePerk PRIMARY KEY (idRace,idPerk),
  ADD CONSTRAINT fkRacePerkRace FOREIGN KEY (idRace) REFERENCES "DD_Race"(idRace),
  ADD CONSTRAINT fkRacePerkPerk FOREIGN KEY (idPerk) REFERENCES "DD_Perk"(idPerk);

ALTER TABLE "DD_ClasseAttribute"
  ADD CONSTRAINT pkClasseAttribute PRIMARY KEY (idClasse,idAttribute),
  ADD CONSTRAINT fkClasseAttributeClasse FOREIGN KEY (idClasse) REFERENCES "DD_Classe"(idClasse),
  ADD CONSTRAINT fkClasseAttributeAttribute FOREIGN KEY (idAttribute) REFERENCES "DD_Attribute"(idAttribute);

ALTER TABLE "DD_ClasseAbilityForm"
  ADD CONSTRAINT pkClasseAbilityForm PRIMARY KEY (idClasse,idAbility),
  ADD CONSTRAINT fkClasseAbilityFormClasse FOREIGN KEY (idClasse) REFERENCES "DD_Classe"(idClasse),
  ADD CONSTRAINT fkClasseAbilityFormAbility FOREIGN KEY (idAbility) REFERENCES "DD_Ability"(idAbility);

ALTER TABLE "DD_ClasseDefenceBonus"
  ADD CONSTRAINT pkClasseDefenceBonus PRIMARY KEY (idClasse,idDefence),
  ADD CONSTRAINT fkClasseDefenceBonusClasse FOREIGN KEY (idClasse) REFERENCES "DD_Classe"(idClasse),
  ADD CONSTRAINT fkClasseDefenceBonusDefence FOREIGN KEY (idDefence) REFERENCES "DD_Defence"(idDefence);

ALTER TABLE "DD_ClassePerk"
  ADD CONSTRAINT pkClassePerk PRIMARY KEY (idClasse,idPerk),
  ADD CONSTRAINT fkClassePerkClasse FOREIGN KEY (idClasse) REFERENCES "DD_Classe"(idClasse),
  ADD CONSTRAINT fkClassePerkPerk FOREIGN KEY (idPerk) REFERENCES "DD_Perk"(idPerk);

ALTER TABLE "DD_DefenceAttribute"
  ADD CONSTRAINT pkDefenceAttribute PRIMARY KEY (idDefence,idAttribute),
  ADD CONSTRAINT fkDefenceAttributeDefence FOREIGN KEY (idDefence) REFERENCES "DD_Defence"(idDefence),
  ADD CONSTRAINT fkDefenceAttributeAttribute FOREIGN KEY (idAttribute) REFERENCES "DD_Attribute"(idAttribute);

ALTER TABLE "DD_ModifierRequired"
  ADD CONSTRAINT pkModifierRequired PRIMARY KEY (idModifier,idRequired),
  ADD CONSTRAINT fkModifierRequiredModifier FOREIGN KEY (idModifier) REFERENCES "DD_Modifier"(idModifier),
  ADD CONSTRAINT fkModifierRequiredRequired FOREIGN KEY (idRequired) REFERENCES "DD_Required"(idRequired);

ALTER TABLE "DD_PerkRequired"
  ADD CONSTRAINT pkPerkRequired PRIMARY KEY (idPerk,idRequired),
  ADD CONSTRAINT fkPerkRequiredPerk FOREIGN KEY (idPerk) REFERENCES "DD_Perk"(idPerk),
  ADD CONSTRAINT fkPerkRequiredRequired FOREIGN KEY (idRequired) REFERENCES "DD_Required"(idRequired);

ALTER TABLE "DD_PerkModifier"
  ADD CONSTRAINT pkPerkModifier PRIMARY KEY (idPerk,idModifier),
  ADD CONSTRAINT fkPerkModifierPerk FOREIGN KEY (idPerk) REFERENCES "DD_Perk"(idPerk),
  ADD CONSTRAINT fkPerkModifierModifier FOREIGN KEY (idModifier) REFERENCES "DD_Modifier"(idModifier);

ALTER TABLE "DD_PerkSkill"
  ADD CONSTRAINT pkPerkSkill PRIMARY KEY (idPerk,idSkill),
  ADD CONSTRAINT fkPerkSkillPerk FOREIGN KEY (idPerk) REFERENCES "DD_Perk"(idPerk),
  ADD CONSTRAINT fkPerkSkillSkill FOREIGN KEY (idSkill) REFERENCES "DD_Skill"(idSkill);