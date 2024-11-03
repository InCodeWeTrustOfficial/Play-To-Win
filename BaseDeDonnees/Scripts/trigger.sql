CREATE OR REPLACE TRIGGER tr_aft_ins_ExemplaireServices
AFTER INSERT ON p_ExemplaireService
FOR EACH ROW
BEGIN
UPDATE p_Commandes c
SET c.prixTotal = COALESCE(c.prixTotal, 0) + (
    SELECT s.prixService
    FROM p_Services s
    WHERE s.codeService = NEW.codeService
)
WHERE c.idCommande = NEW.idCommande;
END;
