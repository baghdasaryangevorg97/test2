import React, { useState, useEffect } from 'react';
import { Modal, Button, Form } from 'react-bootstrap';
import axios from 'axios';
import { toast } from 'react-toastify';
import DateTime from 'react-datetime';
import 'react-datetime/css/react-datetime.css';
import { instance } from '../../app/configs/AxiosConfig';
import moment from 'moment';

const TaskForm = ({ task, onClose, fetchTasks }) => {
    const [formData, setFormData] = useState({
        title: '',
        description: '',
        status: 'pending',
        due_date: '',
        completed_at: ''
    });

    useEffect(() => {
        if (task) {
            setFormData(task);
        }
    }, [task]);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const handleDateChange = (name, date) => {
        setFormData(prev => ({
            ...prev,
            [name]: date ? date.format('YYYY-MM-DD HH:mm:ss') : '' 
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            if (task) {
                try {
                    const config = {
                        method: "put",
                        url: `/v1/tasks/${task.id}`,
                        data: formData
                    };
        
                    await instance(config);
                } catch (error) {
                    console.log(error.response);
                }

            } else {
                try {
                    const config = {
                        method: "post",
                        url: `/v1/tasks`,
                        data: formData
                    };
        
                    await instance(config);
                } catch (error) {
                    console.log(error.response);
                }
            }
            fetchTasks();
            onClose();
        } catch (error) {
            toast.error('Error saving task');
        }
    };

    return (
        <Modal show onHide={onClose}>
            <Modal.Header closeButton>
                <Modal.Title>{task ? 'Edit task' : 'Add task'}</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <Form onSubmit={handleSubmit}>
                    <Form.Group controlId="formTitle">
                        <Form.Label className='mb-0 mt-2'>Title</Form.Label>
                        <Form.Control
                            type="text"
                            name="title"
                            value={formData.title}
                            onChange={handleChange}
                            required
                        />
                    </Form.Group>
                    <Form.Group controlId="formDescription">
                        <Form.Label className='mb-0 mt-2'>Description</Form.Label>
                        <Form.Control
                            as="textarea"
                            name="description"
                            value={formData.description}
                            onChange={handleChange}
                        />
                    </Form.Group>
                    <Form.Group controlId="formStatus">
                        <Form.Label className='mb-0 mt-2'>Status</Form.Label>
                        <Form.Control
                            as="select"
                            name="status"
                            value={formData.status}
                            onChange={handleChange}
                        >
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </Form.Control>
                    </Form.Group>
                    <Form.Group controlId="formDueDate">
                        <Form.Label className='mb-0 mt-2'>Due Date</Form.Label>
                        <DateTime
                            name="due_date"
                            value={formData.due_date ? moment(formData.due_date) : ''}
                            onChange={(date) => handleDateChange('due_date', date)}
                            dateFormat="MM/DD/YYYY"
                            timeFormat="HH:mm:ss"
                            inputProps={{ className: 'form-control' }}
                        />
                    </Form.Group>
                    {task ?  
                    <Form.Group controlId="formCompletedAt">
                        <Form.Label className='mb-0 mt-2'>Completed At</Form.Label>
                        <DateTime
                            name="completed_at"
                            value={formData.completed_at ? moment(formData.completed_at) : ''}
                            onChange={(date) => handleDateChange('completed_at', date)}
                            dateFormat="MM/DD/YYYY"
                            timeFormat="HH:mm:ss"
                            inputProps={{ className: 'form-control' }}
                        />
                    </Form.Group>
                    : null}
                    <Button className="mt-3" variant="primary" type="submit">
                        {task ? 'Update' : 'Create'}
                    </Button>
                </Form>
            </Modal.Body>
        </Modal>
    );
};

export default TaskForm;
