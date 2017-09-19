/* global baseUrl */
/* global apiKey */
import React from 'react';
import { jsonServerRestClient, simpleRestClient, fetchUtils, Admin, Resource, Delete } from 'admin-on-rest';

import { QuoteList, QuoteEdit, QuoteCreate } from './quotes';
import { AuthorList, AuthorEdit, AuthorCreate } from './authors';
import Dashboard from './dashboard';

const httpClient = (url, options = {}) => {
    if (!options.headers) {
        options.headers = new Headers({'X-Apikey': apiKey});
    }
    // add your own headers here
    //options.headers.set('X-Apikey', apiKey );
    return fetchUtils.fetchJson(url, options);
}

const restClient = jsonServerRestClient(baseUrl, httpClient);

const App = () => (
    <Admin dashboard={Dashboard} restClient={restClient} title="Bootcamp plugin">
        <Resource name="quote" list={QuoteList} edit={QuoteEdit} create={QuoteCreate} remove={Delete} />
        <Resource name="author" list={AuthorList} edit={AuthorEdit} create={AuthorCreate} remove={Delete} />
    </Admin>
);

export default App;