/* global baseUrl */
import React from 'react';
import { jsonServerRestClient, fetchUtils, Admin, Resource, Delete } from 'admin-on-rest';

import { QuoteList, QuoteEdit, QuoteCreate } from './quotes';
import { AuthorList, AuthorEdit, AuthorCreate } from './authors';
import Dashboard from './dashboard';

import authClient from './authClient';
import MyLoginPage from './loginPage';

const httpClient = (url, options = {}) => {
    if (!options.headers) {
        options.headers = new Headers({ Accept: 'application/json' });
    }
    const token = localStorage.getItem('token');
    options.headers.set('Authorization', `Bearer ${token}`);
    return fetchUtils.fetchJson(url, options);
}

const restClient = jsonServerRestClient(baseUrl, httpClient);

const App = () => (
    <Admin dashboard={Dashboard} restClient={restClient} title="Bootcamp plugin" authClient={authClient} loginPage={MyLoginPage}>
        <Resource name="quote" list={QuoteList} edit={QuoteEdit} create={QuoteCreate} remove={Delete} />
        <Resource name="author" list={AuthorList} edit={AuthorEdit} create={AuthorCreate} remove={Delete} />
    </Admin>
);

export default App;