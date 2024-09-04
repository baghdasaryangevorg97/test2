import React from 'react';
import { Navigate } from 'react-router-dom';

const PrivateRoute = ({ children }) => {
    const token = localStorage.getItem('token') ? localStorage.getItem('token') : null;

    return token? children : <Navigate to="/login" />;
  };

export default PrivateRoute;