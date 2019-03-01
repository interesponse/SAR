select t.name,tags.tag from (select tag_map.*,spaces.name from tag_map join spaces on tag_map.space_id=spaces.id) as t join tags on t.tag_id=tags.id;
