document.addEventListener('DOMContentLoaded', () => {
    const addQuestionButton = document.getElementById('addQuestion');
    const questionsContainer = document.getElementById('questions');
    const surveyForm = document.getElementById('surveyForm');
    const answerForm = document.getElementById('answerForm');
    const surveyList = document.getElementById('surveyList');

    if (addQuestionButton) {
        addQuestionButton.addEventListener('click', () => {
            const questionCount = questionsContainer.children.length + 1;
            const newQuestion = document.createElement('div');
            newQuestion.classList.add('question');
            newQuestion.innerHTML = `
                <label>Question ${questionCount}:</label>
                <input type="text" name="questions[]" required>
            `;
            questionsContainer.appendChild(newQuestion);
        });
    }

    if (surveyForm) {
        surveyForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(surveyForm);
            const response = await fetch('survey/create.php', {
                method: 'POST',
                body: formData,
            });
            const result = await response.json();
            alert(result.message);
            if (result.survey_id) {
                window.location.href = 'view_surveys.php';
            }
        });
    }

    if (answerForm) {
        answerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(answerForm);
            const response = await fetch('survey/submit_answer.php', {
                method: 'POST',
                body: formData,
            });
            const result = await response.json();
            alert(result.message);
        });
    }

    if (surveyList) {
        fetch('survey/get_all.php')
            .then(response => response.json())
            .then(surveys => {
                surveys.forEach(survey => {
                    const listItem = document.createElement('li');
                    listItem.textContent = survey.title;
                    listItem.addEventListener('click', () => {
                        window.location.href = `survey_detail.php?survey_id=${survey.id}`;
                    });
                    surveyList.appendChild(listItem);
                });
            });
    }
});


document.addEventListener('DOMContentLoaded', () => {
    let questionCount = 1;

    const addQuestionButton = document.getElementById('addQuestion');
    const questionsContainer = document.getElementById('questions');

    // Function to handle adding new questions
    addQuestionButton.addEventListener('click', () => {
        questionCount++;
        const newQuestion = document.createElement('div');
        newQuestion.classList.add('question', 'form-group');
        newQuestion.innerHTML = `
            <label>Question ${questionCount}:</label>
            <input type="text" name="questions[]" class="input-field" required>
            <label for="question-type-${questionCount}">Answer Type:</label>
            <select name="question-type[]" class="input-field question-type" data-question="${questionCount}">
                <option value="text">Text</option>
                <option value="multiple-choice">Multiple Choice</option>
            </select>
            <div class="options-group" id="options-group-${questionCount}" style="display:none;">
                <label>Options:</label>
                <div class="option">
                    <input type="text" name="options[${questionCount}][]" class="input-field option-field">
                </div>
                <button type="button" class="button add-option-btn" data-question="${questionCount}">Add Option</button>
            </div>
        `;
        questionsContainer.appendChild(newQuestion);
    });

    // Function to handle showing/hiding options based on the selected question type
    document.addEventListener('change', (event) => {
        if (event.target.matches('.question-type')) {
            const questionId = event.target.getAttribute('data-question');
            const optionsGroup = document.getElementById(`options-group-${questionId}`);
            if (event.target.value === 'multiple-choice') {
                optionsGroup.style.display = 'block';
            } else {
                optionsGroup.style.display = 'none';
            }
        }
    });

    // Function to add new option fields for multiple choice questions
    document.addEventListener('click', (event) => {
        if (event.target.matches('.add-option-btn')) {
            const questionId = event.target.getAttribute('data-question');
            const optionsGroup = document.getElementById(`options-group-${questionId}`);
            const newOption = document.createElement('div');
            newOption.classList.add('option');
            newOption.innerHTML = `<input type="text" name="options[${questionId}][]" class="input-field option-field">`;
            optionsGroup.insertBefore(newOption, event.target);
        }
    });
});
