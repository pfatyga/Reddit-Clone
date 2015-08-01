import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    NgFor
} from 'angular2/angular2';
import { RouterLink } from 'angular2/router';
import { DataService } from 'app/services/dataService';

// Subreddit component
@Component({
    selector: 'subreddit',
    hostInjector: [DataService]
})
@View({
    templateUrl: 'app/components/subreddit/subreddit.html',
    directives: [NgFor, RouterLink]
})
export class Subreddit {
    constructor(dataService:DataService) {
    }
}
