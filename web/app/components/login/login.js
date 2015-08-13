import {
    ComponentAnnotation as Component,
    ViewAnnotation as View
} from 'angular2/angular2';
import {
    FormBuilder,
    Validators,
    formDirectives,
    ControlGroup,
    forms
} from 'angular2/forms';
import { DataService } from 'app/services/dataService';

// Login component
@Component({
    selector: 'login',
    hostInjector: [FormBuilder, DataService],
    viewBindings: [
        FormBuilder
    ]
})
@View({
    templateUrl: 'app/components/login/login.html',
    styleUrls: ['app/components/login/login.css'],
    directives: [formDirectives]
})

export class Login {
    loginForm;
    constructor(builder: FormBuilder, dataService: DataService) {

        this.loginForm = builder.group({
            'username': ['', Validators.required],
            'password': ['', Validators.required]
        });
    }
}
