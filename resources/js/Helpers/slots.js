/* By slots I mean positions so I don't have to repeat arrays over and over... */
export const slots = {
    '3v3': {
        offense: ["offense_leader", "offense_slot_2", "offense_slot_3"],
        defense: ["defense_leader", "defense_slot_2", "defense_slot_3"],
    },
    '5v5': {
        offense: ["offense_leader", "offense_slot_2", "offense_slot_3", "offense_slot_4", "offense_slot_5"],
        defense: ["defense_leader", "defense_slot_2", "defense_slot_3", "defense_slot_4", "defense_slot_5"],
    },
    'ships': {
        offense: ["offense_leader", "offense_slot_2", "offense_slot_3", "offense_slot_4", "offense_slot_5", "offense_slot_6", "offense_slot_7", "offense_slot_8"],
        defense: ["defense_leader", "defense_slot_2", "defense_slot_3", "defense_slot_4", "defense_slot_5", "defense_slot_6", "defense_slot_7", "defense_slot_8",],
    },
    offense: ["offense_leader", "offense_slot_2", "offense_slot_3", "offense_slot_4", "offense_slot_5", "offense_slot_6", "offense_slot_7", "offense_slot_8"],
    defense: ["defense_leader", "defense_slot_2", "defense_slot_3", "defense_slot_4", "defense_slot_5", "defense_slot_6", "defense_slot_7", "defense_slot_8",],
}
