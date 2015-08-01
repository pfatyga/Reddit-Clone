import {
    ComponentAnnotation as Component,
    ViewAnnotation as View,
    NgFor
} from 'angular2/angular2';
import { RouterLink } from 'angular2/router';
import { DataService } from 'app/services/dataService';

// Home component
@Component({
    selector: 'home',
    hostInjector: [DataService]
})
@View({
    templateUrl: 'app/components/home/home.html',
    directives: [NgFor, RouterLink]
})
export class Home {
    constructor(dataService:DataService) {

    }
}
