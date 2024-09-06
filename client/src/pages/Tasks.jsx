import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Table, Button } from 'react-bootstrap';
import TaskForm from '../components/task/TaskForm';
import DeleteModal from '../components/task/DeleteModal';
import 'react-toastify/dist/ReactToastify.css';
import { toast } from 'react-toastify';
import { instance } from '../app/configs/AxiosConfig';


const Task = () => {
    const [tasks, setTasks] = useState([]);
    const [isEditing, setIsEditing] = useState(false);
    const [editingTask, setEditingTask] = useState(null);
    const [showDeleteModal, setShowDeleteModal] = useState(false);
    const [deletingTaskId, setDeletingTaskId] = useState(null);

    useEffect(() => {
        fetchTasks();
    }, []);

    const fetchTasks = async () => {
        try {
            const config = {
                method: "get",
                url: "/v1/
                ",
            };

            const response = await instance(config);
            setTasks(response.data.data);
        } catch (error) {
            console.log(error.response);
        }
    };

    const handleEdit = (task) => {
        setIsEditing(true);
        setEditingTask(task);
    };

    const handleDelete = (taskId) => {
        setShowDeleteModal(true);
        setDeletingTaskId(taskId);
    };

    const handleDeleteConfirm = async () => {
        try {
            const config = {
                method: "delete",
                url: `/v1/tasks/${deletingTaskId}`,
            };
            const response = await instance(config);
            toast.error('Task Removed');
            fetchTasks();
            setShowDeleteModal(false);
        } catch (error) {
            toast.error('Something went wrong');
        }
    };

    return (
        <div className="container mt-4">
            <Button variant="primary" onClick={() => setIsEditing(true)}>Add task</Button>
            <Table striped bordered hover className="mt-4">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Deadline</th>
                        <th>Completed</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    { tasks.map(task => (
                        <tr key={task.id}>
                            <td>{task.title}</td>
                            <td>{task.description}</td>
                            <td>{task.due_date}</td>
                            <td>{task.completed_at}</td>
                            <td>{task.status}</td>
                            <td>
                                <Button variant="warning" onClick={() => handleEdit(task)}>Edit</Button>
                                <Button variant="danger" className='mx-2' onClick={() => handleDelete(task.id)}>Delete</Button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </Table>

            {isEditing && (
                <TaskForm task={editingTask} onClose={() => setIsEditing(false)} fetchTasks={fetchTasks} />
            )}
            {showDeleteModal && (
                <DeleteModal
                    show={showDeleteModal}
                    onConfirm={handleDeleteConfirm}
                    onCancel={() => setShowDeleteModal(false)}
                />
            )}
        </div>
    );
};

export default Task;
