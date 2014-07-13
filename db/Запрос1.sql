SELECT catalog__model_property.value_list
     , catalog__model_property.flag_disc
     , catalog__model_property.id_model_god
     , catalog__model_property.id
     , catalog__model_property.id_property
     , catalog__data_list_property.name
     , catalog__model_property.value
     , catalog__model_property.id_model
FROM
  catalog__model_property
LEFT JOIN catalog__data_list_property
ON catalog__model_property.id_property = catalog__data_list_property.id_property