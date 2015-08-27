import {
    ComponentMetadata as Component,
    ViewMetadata as View
} from 'angular2/angular2';
import { Location } from 'angular2/router';
import { Http } from 'http/http';
import {
    FormBuilder,
    Validators,
    FORM_DIRECTIVES,
    ControlGroup,
    forms
} from 'angular2/forms';

import { host } from 'app/services/dataService';

import { App } from 'app/components/app/app';

// Login component
@Component({
    selector: 'login',
    hostInjector: [FormBuilder],
    viewBindings: [
        FormBuilder
    ]
})
@View({
    templateUrl: 'app/components/login/login.html',
    styleUrls: ['app/components/login/login.css'],
    directives: [FORM_DIRECTIVES]
})

export class Login {
    loginForm;
    message;
    constructor(app: App, location: Location, builder: FormBuilder, http: Http) {
        this.app = app;
        this.http = http;
        this.location = location;
        this.message = '';
        this.loginForm = builder.group({
            'username': ['', Validators.required],
            'password': ['', Validators.required]
        });
    }

    login(username, password) {
        return this.http.post(host + '/api/login', 'username=' + username + '&password=' + password, {headers: {
            'Content-type': 'application/x-www-form-urlencoded'
        }})
            .toRx()
            .toPromise();
    }

    submit() {
        this.login(this.loginForm.controls.username.value, this.loginForm.controls.password.value).then(function (result) {
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
