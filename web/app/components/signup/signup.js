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

// Signup component
@Component({
    selector: 'signup',
    hostInjector: [FormBuilder, DataService],
    viewBindings: [
        FormBuilder
    ]
})
@View({
    templateUrl: 'app/components/signup/signup.html',
    styleUrls: ['app/components/signup/signup.css'],
    directives: [formDirectives]
})

export class Signup {
    signupForm;
    constructor(builder: FormBuilder, dataService: DataService) {
        this.signupForm = builder.group({
            'email':    ['', Validators.required],
            'username': ['', Validators.required],
            'password': ['', Validators.required]
        });
    }
}
