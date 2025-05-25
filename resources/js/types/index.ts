export interface GameInterface {
    awayTeamId: number;
    endTime: string;
    gameType: number;
    homeTeamId: number;
    playoffGameNumber: number;
    playoffRound: number;
    recapLong: string;
    recapShort: string;
    startTime: string;
    venue: string;
}

export interface TeamInterface {
    code: string;
    id: number;
    location: string;
    name: string;
}

export enum FILE_TYPE {
    CSV = 'csv',
    ICAL = 'ical',
}

export enum GAME_TYPE {
    PRESEASON = 1,
    REGULAR = 2,
    PLAYOFF = 3,
}

export enum TRANSFORM_TEXT {
    LOWERCASE = 'lowercase',
    UPPERCASE = 'uppercase',
}

export enum URLS {
    HOME = '/',
    SCHEDULE = '/schedule',
    TEAMS = '/teams',
}
