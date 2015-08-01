import { ComponentAnnotation as Component } from 'angular2/angular2';
import { Http } from 'angular2/http';

export class DataService {
    constructor(http:Http) {
        this.http = http;
        this.host = 'http://private-2e4ca-redditclone.apiary-mock.com';
    }

    getSubreddit(name) {
        return this.http.get(this.host + '/api/subreddits/' + name);
    }
}
