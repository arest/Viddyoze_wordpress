/* global redirectOnAuthError */

import React, { Component } from 'react';
import { connect } from 'react-redux';
import { userLogin } from 'admin-on-rest';
import queryString from 'query-string';
import RaisedButton from 'material-ui/RaisedButton';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import {Card, CardHeader, CardText} from 'material-ui/Card';


class MyLoginPage extends Component {

    submit = (e) => {
        e.preventDefault();
        window.location.replace(redirectOnAuthError);
    }

    componentDidMount = function() {
        const parsedHash = queryString.parse(window.location.search);
        console.log(parsedHash);
        var access_token = parsedHash['access_token'];

        if( access_token ) {
            const credentials = { access_token };
            this.props.userLogin(credentials);
        }
    }

    render() {
        return (
            <div>
            <MuiThemeProvider>
                <Card>
                    <CardHeader
                    title="Login"
                    actAsExpander={false}
                    showExpandableButton={false}
                    />
                    <CardText expandable={false}>
                            <form onSubmit={this.submit}>
                            In order to use this application you have to login.<br /><br />
                            <RaisedButton onClick={this.submit} label="OK. Proceed" />
                        </form>
                    </CardText>
                </Card>
                
            </MuiThemeProvider>
            </div>
        );
    }
};

export default connect(undefined, { userLogin })(MyLoginPage);