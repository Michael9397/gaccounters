import {nicknames} from "./nicknames"

export function fuzzySearchWithNicknames(options, searchTerm) {
    searchTerm = searchTerm.toLowerCase();
    let option = {};
    if (nicknames[searchTerm]) {
        option = options.filter(opt => opt.name == nicknames[searchTerm]);
        if (option.length >= 1) {
            return option;
        }
    }
    let pattern = '.*' + searchTerm.split('').join('.*') + '.*';
    const re = new RegExp(pattern);
    return options.filter(option => re.test(option.name.toLowerCase()));
}

export function fuzzySearch (options, searchTerm) {
    searchTerm = searchTerm.toLowerCase();
    let option = {};
    let pattern = '.*' + searchTerm.split('').join('.*') + '.*';
    const re = new RegExp(pattern);
    return options.filter(option => re.test(option.name.toLowerCase()));
}

