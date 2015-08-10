import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    Inject
} from 'angular2/angular2';
import {
    FormBuilder,
    Validators,
    formDirectives,
    ControlGroup
} from 'angular2/forms';
import { RouteParams, RouterLink } from 'angular2/router';
import { DataService } from 'app/services/dataService';


// Login component
@Component({
    selector: 'login',
    hostInjector: [DataService]
})
@View({
    templateUrl: 'app/components/login/login.html',
    styleUrls: ['app/components/login/login.css'],
    directives: [RouterLink]
})
export class Login {
    constructor(@Inject(RouteParams) routeParams: RouteParams, dataService: DataService) {
        this.subreddit = routeParams.params.name;
        dataService.getSubreddit(this.subreddit).subscribe(function (subreddit) {
            this.name = subreddit.name;
            this.posts = subreddit.posts;
        }.bind(this));
    }
}
