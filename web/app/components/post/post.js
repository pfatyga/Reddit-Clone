import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject
} from 'angular2/angular2';
import { Location } from 'angular2/router';
import {
    FormBuilder,
    Validators,
    FORM_DIRECTIVES,
    ControlGroup,
    forms
} from 'angular2/forms';
import { RouteParams, RouterLink } from 'angular2/router';

import { Http } from 'http/http';
import { host } from 'app/services/dataService';

// Post component
@Component({
    selector: 'post',
    hostInjector: [FormBuilder],//, DataService],
    viewBindings: [
        FormBuilder
    ]
})
@View({
    templateUrl: 'app/components/post/post.html',
    styleUrls: ['app/components/post/post.css'],
    directives: [FORM_DIRECTIVES, RouterLink]
})

export class Post {
    postForm;
    message;
    constructor(location: Location, @Inject(RouteParams) routeParams: RouteParams, builder: FormBuilder, http: Http) {
        this.location = location;
        this.http = http;
        this.subreddit = routeParams.params.subreddit;
        this.postForm = builder.group({
            'title':    ['', Validators.required],
            'url':     ['', Validators.required],
            'imageUrl': [''],
            'content':  ['', Validators.required],
        });
    }

    submitPost(title, content, url, imageUrl) {
        return this.http.post(host + '/api/subreddits/' + this.subreddit + '/new',
            'title=' + title + '&content=' + content + '&url=' + url + '&imageUrl=' + imageUrl, {
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
            .toRx()
            .toPromise();
    }

    submit() {
        this.submitPost('blah', 'blah', 'blah').then(function (test) {
            debugger;
        }, function (test) {
            debugger;
        });
        this.location.back();
    }

}
