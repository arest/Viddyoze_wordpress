// in src/posts.js
import React from 'react';
import { List, Edit, Create, Datagrid, TextField, EditButton, DisabledInput, LongTextInput, ReferenceInput, SelectInput, SimpleForm } from 'admin-on-rest';

export const QuoteList = (props) => (
    <List {...props}>
        <Datagrid>
            <TextField source="id" />
            <TextField source="author.lastName" label="Author" />
            <TextField source="content" />
            <EditButton />
        </Datagrid>
    </List>
);

const QuoteTitle = ({ record }) => {
    return <span>Quote {record ? `"${record.content}"` : ''}</span>;
};

export const QuoteEdit = (props) => (
    <Edit title={<QuoteTitle />} {...props}>
        <SimpleForm>
            <DisabledInput source="id" />
            <ReferenceInput label="Author" source="authorId" reference="author">
                <SelectInput optionText="lastName" />
            </ReferenceInput>
            <LongTextInput source="content" />
        </SimpleForm>
    </Edit>
);

export const QuoteCreate = (props) => (
    <Create {...props}>
        <SimpleForm>
            <ReferenceInput label="Author" source="authorId" reference="author">
                <SelectInput optionText="lastName" />
            </ReferenceInput>
            <LongTextInput source="content" />
        </SimpleForm>
    </Create>
);