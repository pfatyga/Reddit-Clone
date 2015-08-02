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
            .map(res => res.json());
    }

    getUser(name) {
        return this.http.get(this.host + '/api/users/' + name)
            .toRx()
            .map(res => res.json());
    }

    getFrontPage() {
        return this.http.get(this.host + '/api/posts')
            .toRx()
            .map(res => res.json());
    }
}
