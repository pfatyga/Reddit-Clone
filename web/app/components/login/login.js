import {
    ComponentMetadata as Component,
    ViewMetadata as View
} from 'angular2/angular2';
import { Location } from 'angular2/router';
import {
    FormBuilder,
    Validators,
    FORM_DIRECTIVES,
    ControlGroup,
    forms
} from 'angular2/forms';

import { DataService } from 'app/services/dataService';

import { App } from 'app/components/app/app';

// Login component
@Component({
    selector: 'login',
    hostInjector: [FormBuilder],
    viewBindings: [
        FormBuilder
    ],
    bindings: [DataService]
})
@View({
    templateUrl: 'app/components/login/login.html',
    styleUrls: ['app/components/login/login.css'],
    directives: [FORM_DIRECTIVES]
})

export class Login {
    loginForm;
    message;
    constructor(dataService: DataService, app: App, location: Location, builder: FormBuilder) {
        this.dataService = dataService;
        this.app = app;
        this.location = location;
        this.message = '';
        this.loginForm = builder.group({
            'username': ['', Validators.required],
            'password': ['', Validators.required]
        });
    }

    submit() {
        this.dataService.login(this.loginForm.controls.username.value, this.loginForm.controls.password.value).then(function (result) {
            if(result.status == 200) {
                var user = result.json();
                this.app.login(user);
                this.location.back();
            } else {
                this.message = result.text();
            }
        }.bind(this), function(err) {
            this.message = 'An error occurred: ' + JSON.stringify(err);
        }.bind(this));
    }
}
