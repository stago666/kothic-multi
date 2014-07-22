ALTER TABLE smf_membergroups
ADD icon varchar(255)
DEFAULT NULL;

ALTER TABLE smf_membergroups
ADD priority integer
DEFAULT 0;