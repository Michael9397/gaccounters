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
