CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `rh_tristone`.`vw_areas_cros_celula` AS
    SELECT 
        `rh_tristone`.`turno`.`turno` AS `turno`,
        `rh_tristone`.`areas`.`area` AS `area`,
        `rh_tristone`.`clientes`.`cliente` AS `cliente`,
        `rh_tristone`.`celulas`.`celula` AS `celula`,
        `rh_tristone`.`turno`.`id` AS `idTurno`,
        `rh_tristone`.`areas`.`id` AS `idArea`,
        `rh_tristone`.`clientes`.`id` AS `idCliente`,
        `rh_tristone`.`celulas`.`id` AS `idCelula`
    FROM
        ((((`rh_tristone`.`turno`
        JOIN `rh_tristone`.`turno_areas` ON ((`rh_tristone`.`turno`.`id` = `rh_tristone`.`turno_areas`.`turno_id`)))
        JOIN `rh_tristone`.`areas` ON ((`rh_tristone`.`turno_areas`.`areas_id` = `rh_tristone`.`areas`.`id`)))
        JOIN `rh_tristone`.`clientes` ON ((`rh_tristone`.`areas`.`id` = `rh_tristone`.`clientes`.`areas_id`)))
        JOIN `rh_tristone`.`celulas` ON ((`rh_tristone`.`clientes`.`id` = `rh_tristone`.`celulas`.`clientes_id`)))
