import {
    ComponentMetadata as Component,
    ViewMetadata as View,
    Inject
} from 'angular2/angular2';
import {
    FormBuilder,
    Validators,
    FORM_DIRECTIVES,
    ControlGroup,
    forms
} from 'angular2/forms';
import { Router, RouteParams, RouterLink } from 'angular2/router';
import { DataService } from 'app/services/dataService';

// Post component
@Component({
    selector: 'post',
    hostInjector: [FormBuilder],
    viewBindings: [
        FormBuilder
    ],
    bindings: [DataService]
})
@View({
    templateUrl: 'app/components/post/post.html',
    styleUrls: ['app/components/post/post.css'],
    directives: [FORM_DIRECTIVES, RouterLink]
})

export class Post {
    postForm;
    message;
    constructor(dataService: DataService, router: Router, @Inject(RouteParams) routeParams: RouteParams, builder: FormBuilder) {
        this.dataService = dataService;
        this.router = router;
        this.subreddit = routeParams.params.subreddit;
        this.postForm = builder.group({
            'title':    ['', Validators.required],
            'url':     ['', Validators.required],
            'imageUrl': [''],
            'content':  ['', Validators.required],
        });
    }

    submit() {
        var title = this.postForm.controls.title.value;
        var content = this.postForm.controls.content.value;
        var url = this.postForm.controls.url.value;
        var imageUrl = this.postForm.controls.imageUrl.value;
        this.dataService.submitPost(this.subreddit, title, content, url, imageUrl).then(function (result) {
            if(result.status === 200) {
                var post_id = parseInt(result.text());
                this.router.parent.navigate('/r/' + this.subreddit + '/' + post_id);
            } else if(result.status === 401) {
                this.router.parent.navigate('/login');
            } else {
                this.message = result.text();
            }
        }.bind(this), function(err) {
            this.message = 'An error occurred: ' + JSON.stringify(err);
        }.bind(this));
    }

}
