import { ComponentAnnotation as Component } from 'angular2/angular2';
import { Http } from 'angular2/http';
import { Observable } from 'rx';

export class DataService {
    constructor(http:Http) {
        this.http = http;
        this.host = 'http://private-8dc259-redditclone.apiary-mock.com';
    }

    getSubreddit(name) {
        return this.http.get(this.host + '/api/subreddits/' + name)
            .toRx()
            .map(res => res._body);
    }

    getUser(name) {
        return this.http.get(this.host + '/api/users/' + name)
            .toRx()
            .map(res => res._body); //not sure why the json was in res._body
    }
}
