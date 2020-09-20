import {slots} from "./slots"

export function getOffense(row) {
    let team = slots.offense.reduce((acc, value) => {
        if (row[value]) {
            acc += `<span>${this.charactersKeyed[row[value]].name}</span><br>`;
        }
        return acc;
    }, '');
    return team;
};
export function getDefense(row) {
    let team = slots.defense.reduce((acc, value) => {
        if (row[value]) {
            acc += `<span>${this.charactersKeyed[row[value]].name}</span><br>`;
        }
        return acc;
    }, '');
    return team;
};

export function getBattle(row) {
    let ids = JSON.parse(row.character_ids);
    return ids.reduce((acc, value) => {
        acc += `<span>${this.charactersKeyed[value].name}</span><br>`;
        return acc;
    }, '');
};
