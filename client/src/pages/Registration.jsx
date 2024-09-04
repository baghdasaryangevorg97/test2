import React, { useState } from 'react'
import { MDBContainer, MDBCol, MDBRow, MDBInput } from 'mdb-react-ui-kit';
import axios from 'axios';
import { Link, useNavigate } from 'react-router-dom';



const Registration = () => {

    const [data, setData] = useState({});
    const [error, setError] = useState({});
    const navigate = useNavigate();

    const handleSubmit = () => {
        axios.post(`${process.env.REACT_APP_BASE_API_DEV}/v1/auth/register`, data)
            .then(function (response) {
                console.log(response.data.success);
                localStorage.setItem('auth_token', response.data.token);
                navigate('/');
            })
            .catch(function (error) {
                setError(error.response.data.errors);
                console.log(error.response.data.errors);
            });

    };

    return (
        <MDBContainer fluid className="p-3 my-5 h-custom">
            <MDBRow>
                <MDBCol col='10' md='6'>
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" className="img-fluid" alt="Sample image" />
                </MDBCol>
                <MDBCol col='4' md='6' className='d-flex flex-column justify-content-center'>

                    <MDBInput wrapperClass='mb-4' onChange={e => setData({ ...data, email: e.target.value })} label='Email address' id='formControlLg' type='email' size="lg" />
                    <MDBInput wrapperClass='mb-4' onChange={e => setData({ ...data, name: e.target.value })} label='Name' id='formControlLg' type='text' size="lg" />
                    <MDBInput wrapperClass='mb-4' onChange={e => setData({ ...data, password: e.target.value })} label='Password' id='formControlLg' type='password' size="lg" />
                    <MDBInput wrapperClass='mb-4' onChange={e => setData({ ...data, password_confirmation: e.target.value })} label='Password-Confirmation' id='formControlLg' type='password' size="lg" />
                    {Object.keys(error).length > 0 && (
                        <div style={{ color: 'red' }}>
                            {Object.keys(error).map((key, index) => (
                                <p key={index}>{error[key]}</p>
                            ))}
                        </div>
                    )}

                    <div className='text-center text-md-start mt-4 pt-2'>
                        <button type="button" className="btn btn-primary btn-lg mb-0 px-5" onClick={handleSubmit}>Registration</button>
                        <p className="small fw-bold mt-2 pt-1 mb-2">Do you have an account? <Link to={'/login'} className="link-danger">Login</Link></p>
                    </div>

                </MDBCol>
            </MDBRow>
        </MDBContainer>
    )
}

export default Registration