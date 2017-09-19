// in src/posts.js
import React from 'react';
import { List, Edit, Create, Datagrid, TextField, EditButton, DisabledInput, LongTextInput, ReferenceInput, SelectInput, SimpleForm } from 'admin-on-rest';

const validateCreation = (values) => {
    const errors = {};
    if (!values.authorId) {
        errors.authorId = ['The author is required'];
    }
    if (!values.content) {
        errors.content = ['The content is required'];
    }
    return errors
};

export const QuoteList = (props) => (
    <List {...props}>
        <Datagrid>
            <TextField source="id" />
            <TextField source="author.lastName" label="Author" sortable={false} />
            <TextField source="content" />
            <EditButton />
        </Datagrid>
    </List>
);

const QuoteTitle = ({ record }) => {
    return <span>Quote {record ? `"${record.id}"` : 'creation'}</span>;
};

export const QuoteEdit = (props) => (
    <Edit title={<QuoteTitle />} {...props}>
        <SimpleForm validate={validateCreation}>
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
        <SimpleForm validate={validateCreation}>
            <ReferenceInput label="Author" source="authorId" reference="author" allowEmpty>
                <SelectInput optionText="lastName" />
            </ReferenceInput>
            <LongTextInput source="content" />
        </SimpleForm>
    </Create>
);