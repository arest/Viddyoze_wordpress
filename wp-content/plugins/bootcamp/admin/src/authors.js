// in src/posts.js
import React from 'react';
import { List, Edit, Create, Datagrid, TextField, EmailField, EditButton, DisabledInput, TextInput, SimpleForm } from 'admin-on-rest';

const validateCreation = (values) => {
    const errors = {};
    if (!values.firstName) {
        errors.firstName = ['The firstName is required'];
    }
    if (!values.lastName) {
        errors.lastName = ['The lastName is required'];
    }
    if (!values.email) {
        errors.email = ['The email is required'];
    }
    if (!/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i.test(values.email)) {
        errors.email = 'The email is not valid';
    }
    return errors
};

export const AuthorList = (props) => (
    <List {...props}>
        <Datagrid>
            <TextField source="id" />
            <TextField source="firstName" label="Name" />
            <TextField source="lastName" label="Surname" />
            <EmailField source="email" />
            <EditButton />
        </Datagrid>
    </List>
);


const AuthorTitle = ({ record }) => {
    return <span>Author {record ? `"${record.lastName}"` : 'creation'}</span>;
};

export const AuthorEdit = (props) => (
    <Edit title={<AuthorTitle />} {...props}>
        <SimpleForm validate={validateCreation}>
        <DisabledInput source="id" />
            <TextInput source="firstName" label="Name" />
            <TextInput source="lastName" label="Surname" />
            <TextInput source="email" label="E-mail" />
        </SimpleForm>
    </Edit>
);

export const AuthorCreate = (props) => (
    <Create {...props}>
        <SimpleForm validate={validateCreation}>
            <TextInput source="firstName" label="Name" />
            <TextInput source="lastName" label="Surname" />
            <TextInput source="email" label="E-mail" />
        </SimpleForm>
    </Create>
);