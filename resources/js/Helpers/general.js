export function showDate(date) {
    if (!date) return '';
    let parts = date.split('-');
    if (parts.length !== 3) return '';
    return `${parts[1]}/${parts[2]}/${parts[0]}`
}

export function keyById(objects) {
    return objects.reduce((acc, item) => {
        acc[item.id] = item;
        return acc;
    }, {});
}

export function getVideoUrl(battle) {
    return this.videosKeyed[battle.video_id].url;
};

export function getCreator(battle) {
    let creatorId = this.videosKeyed[battle.video_id].creator_id;
    return this.creatorsKeyed[creatorId].name;
}

export function addTimeToVideo(battle) {
    let url = this.videosKeyed[battle.video_id].url;
    if (!url.includes('youtube')) return url;

    let sections = battle.video_timestamp.split(':');
    let multiplier = sections.length == 3 ? [3600, 60, 1] : [60, 1];
    let seconds = 0;
    for (let i in sections) {
        seconds += Number(sections[i]) * multiplier[i];
    }
    let strpos = url.indexOf('?') + 1;
    return `${url.slice(0, strpos)}start=${seconds}&${url.slice(strpos)}`;



}
