export function filterCharacters() {
    if (this.battle_type == 'training') {
        return this.characters;
    }
    if (this.battle_type == "ships") {
        return this.characters.filter(character => character.combat_type == "SHIP")
                   .filter(character => !character.category_id_list.includes('role_capital'));
    }
    return this.characters.filter(character => character.combat_type == "CHARACTER");
};

export function filterLeaderCharacters() {
    if (battle_type == 'training') {
        return characters;
    }
    if (this.battle_type == "ships") {
        return characters.filter(character => character.category_id_list.includes('role_capital'));
    }
    return characters.filter(character => character.combat_type == "CHARACTER");
};
