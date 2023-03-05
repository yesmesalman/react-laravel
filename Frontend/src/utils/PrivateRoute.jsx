import React from 'react';
import { Navigate, Outlet } from 'react-router-dom';
import Global from './../helpers/Global'

const PrivateRoute = () => {
    // determine if authorized, from context or however you're doing it
    const auth = Global.isAuthenticated()

    // If not, return element that will navigate to login page
    return auth ? <Outlet /> : <Navigate to="/signin" />;
}

export default PrivateRoute;