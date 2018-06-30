<div class="container">
    <div class="messages <?= (isset($data['messages']['error']) ? 'error' : (isset($data['messages']['success']) ? 'success' : '')) ?>">
        <?php if (!empty($data['messages'])) : ?>
            <ul>
                <?php foreach (array_shift($data['messages']) as $message): ?>
                    <li> <?= $message ?> </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="form">
        <form action="<?= URL; ?>student/addstudent" method="POST">
            <table>
                <tbody><tr>
                    <td><label>First Name</label></td>
                    <td> <input type="text" name="student[first_name]" alt="First Name"
                                value="<?= (isset($data['formdata']['first_name']) ? $data['formdata']['first_name'] : '') ?>"
                                required/></td>
                </tr>
                <tr>
                    <td><label>Last Name</label></td>
                    <td><input type="text" name="student[last_name]" alt="Last Name"
                               value="<?= (isset($data['formdata']['last_name']) ? $data['formdata']['last_name'] : '') ?>"
                               required/></td>
                </tr>

                <tr>
                    <td><label>Subject</label></td>
                    <td> <select multiple name="student[subjects][]" id="subjects" alt="Subject" required>
                            <?php if (isset($data['subjects'])) : ?>
                                <?php foreach ($data['subjects'] as $subject) : ?>
                                    <option value="<?= $subject->subject_id ?>" <?= ((isset($data['formdata']['subjects']) && array_search($subject->subject_id,
                                            $data['formdata']['subjects']) !== false) ? 'selected' : '') ?>><?= $subject->subject ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="save_student_data" value="Save"/></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div class="list">
        <h3>Student List</h3>
        <?php if (!empty($data['students'])) : ?>
            <table>
                <thead>
                <tr>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Subject</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data['students'] as $student) : ?>
                    <tr>
                        <td><?= (isset($student['first_name']) ? htmlspecialchars($student['first_name'], ENT_QUOTES,
                                'UTF-8') : ''); ?></td>
                        <td><?= (isset($student['last_name']) ? htmlspecialchars($student['last_name'], ENT_QUOTES,
                                'UTF-8') : ''); ?></td>
                        <td><?= (isset($student['subject']) ? htmlspecialchars($student['subject'], ENT_QUOTES,
                                'UTF-8') : ''); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            No Student Data
        <?php endif; ?>
    </div>
</div>
