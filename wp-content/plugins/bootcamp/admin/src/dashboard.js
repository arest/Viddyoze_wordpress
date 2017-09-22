// in src/Dashboard.js
import React from 'react';
import { Card, CardHeader, CardText } from 'material-ui/Card';

export default () => (
    <Card style={{ margin: '2em' }}>
        <CardHeader title="Welcome to the bootcamp plugin" />
        <CardText>Manage authors and quotes</CardText>
    </Card>
);