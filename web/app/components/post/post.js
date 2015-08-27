import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject
} from 'angular2/angular2';
import { Router } from 'angular2/router';
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
    constructor(router: Router, @Inject(RouteParams) routeParams: RouteParams, builder: FormBuilder, http: Http) {
        this.router = router;
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
        this.submitPost(this.postForm.controls.title.value, this.postForm.controls.content.value, this.postForm.controls.url.value, this.postForm.controls.imageUrl.value).then(function (ret) {
            if(ret.status == 200) {
                var post_id = parseInt(ret.text());
                this.router.parent.navigate('/r/' + this.subreddit + '/' + post_id);
            } else {
                this.message = ret.text();
            }
        }.bind(this), function(err) {
            this.message = 'An error occurred: ' + JSON.stringify(err);
        }.bind(this));
    }

}
