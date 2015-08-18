import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    Inject
} from 'angular2/angular2';
import {
    FormBuilder,
    Validators,
    formDirectives,
    ControlGroup,
    forms
} from 'angular2/forms';
import { RouteParams, RouterLink } from 'angular2/router';
import { DataService } from 'app/services/dataService';

// Post component
@Component({
    selector: 'post',
    hostInjector: [FormBuilder, DataService],
    viewBindings: [
        FormBuilder
    ]
})
@View({
    templateUrl: 'app/components/post/post.html',
    styleUrls: ['app/components/post/post.css'],
    directives: [formDirectives, RouterLink]
})

export class Post {
    postForm;
    constructor(@Inject(RouteParams) routeParams: RouteParams, builder: FormBuilder, dataService: DataService) {
        this.subreddit = routeParams.params.subreddit;
        this.postForm = builder.group({
            'title':    ['', Validators.required],
            'link':     ['', Validators.required],
            'content':  ['', Validators.required],
        });
    }
}
