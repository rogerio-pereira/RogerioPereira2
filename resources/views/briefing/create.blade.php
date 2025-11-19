<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Briefing - Software Development</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --bg-primary: #05080D;
            --bg-secondary: #111826;
            --bg-tertiary: #2E4959;
            --text-secondary: #B4C0C6;
            --text-primary: #6B8A99;
            --accent: #7D49CC;
        }
        
        body {
            font-family: 'IBM Plex Sans', sans-serif;
            font-weight: 400;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
        }
        
        h1, h2, h3 {
            font-family: 'Share Tech Mono', monospace;
            color: #ffffff;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #ffffff 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }
        
        .form-container {
            background: var(--bg-secondary);
            padding: 40px;
            border-radius: 12px;
            border: 1px solid var(--bg-tertiary);
        }
        
        /* Stepper */
        .stepper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
        }
        
        .stepper::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--bg-tertiary);
            z-index: 0;
        }
        
        .step {
            position: relative;
            z-index: 1;
            text-align: center;
            flex: 1;
        }
        
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg-tertiary);
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-family: 'Share Tech Mono', monospace;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .step.active .step-circle {
            background: var(--accent);
            color: #ffffff;
        }
        
        .step.completed .step-circle {
            background: #4CAF50;
            color: #ffffff;
        }
        
        .step-label {
            font-size: 0.85rem;
            color: var(--text-primary);
        }
        
        .step.active .step-label {
            color: #ffffff;
        }
        
        /* Form Steps */
        .form-step {
            display: none;
        }
        
        .form-step.active {
            display: block;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            color: var(--text-secondary);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 14px 18px;
            background: var(--bg-primary);
            border: 1px solid var(--bg-tertiary);
            border-radius: 8px;
            color: #ffffff;
            font-family: 'IBM Plex Sans', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(125, 73, 204, 0.1);
        }
        
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: rgba(180, 192, 198, 0.4);
        }
        
        .form-group input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
            cursor: pointer;
        }
        
        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 10px;
        }
        
        .checkbox-group label {
            display: flex;
            align-items: center;
            cursor: pointer;
            color: var(--text-primary);
            font-weight: normal;
        }
        
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 25px;
            color: #ffffff;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--bg-tertiary);
        }
        
        .help-text {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-top: 5px;
            font-style: italic;
        }
        
        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            gap: 15px;
        }
        
        .btn {
            padding: 14px 32px;
            border-radius: 8px;
            font-family: 'Share Tech Mono', monospace;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-primary {
            background: var(--accent);
            color: #ffffff;
        }
        
        .btn-primary:hover {
            background: #6a3db0;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(125, 73, 204, 0.3);
        }
        
        .btn-secondary {
            background: transparent;
            color: var(--accent);
            border: 2px solid var(--accent);
        }
        
        .btn-secondary:hover {
            background: var(--accent);
            color: #ffffff;
        }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .error-message {
            color: #ff6b6b;
            font-size: 0.9rem;
            margin-top: 5px;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px 10px;
            }
            
            .form-container {
                padding: 25px 20px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .stepper {
                flex-wrap: wrap;
            }
            
            .step {
                flex: 0 0 50%;
                margin-bottom: 20px;
            }
            
            .checkbox-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tell Us About Your Project</h1>
            <p>Help us understand your problem and how we can help solve it</p>
        </div>
        
        <div class="form-container">
            <form id="briefingForm" action="{{ route('briefing.store') }}" method="POST">
                @csrf
                
                <!-- Stepper -->
                <div class="stepper">
                    <div class="step active" data-step="1">
                        <div class="step-circle">1</div>
                        <div class="step-label">Business Info</div>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-circle">2</div>
                        <div class="step-label">Your Problem</div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-circle">3</div>
                        <div class="step-label">The Project</div>
                    </div>
                    <div class="step" data-step="4">
                        <div class="step-circle">4</div>
                        <div class="step-label">Timeline & Budget</div>
                    </div>
                    <div class="step" data-step="5">
                        <div class="step-circle">5</div>
                        <div class="step-label">Existing Materials</div>
                    </div>
                    <div class="step" data-step="6">
                        <div class="step-circle">6</div>
                        <div class="step-label">Contact Info</div>
                    </div>
                </div>
                
                <!-- Step 1: Business Information -->
                <div class="form-step active" data-step="1">
                    <h2 class="section-title">Business Information</h2>
                    
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone / WhatsApp</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="business_segment">Business Segment / Industry *</label>
                        <input type="text" id="business_segment" name="briefing[business_info][business_segment]" required placeholder="e.g., E-commerce, Services, Education, Healthcare, etc.">
                    </div>
                    
                    <div class="form-group">
                        <label for="business_years">How long has your business been operating? *</label>
                        <input type="text" id="business_years" name="briefing[business_info][business_years]" required placeholder="This helps us understand the amount of data the system will handle">
                    </div>
                    
                    <div class="form-group">
                        <label for="team_size">How many people work in your business today? *</label>
                        <select id="team_size" name="briefing[business_info][team_size]" required>
                            <option value="">Select option...</option>
                            <option value="just-me">Just me</option>
                            <option value="2-5">2-5 people</option>
                            <option value="6-10">6-10 people</option>
                            <option value="11-20">11-20 people</option>
                            <option value="more-than-20">More than 20 people</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="current_operation">How would you describe your current operation? *</label>
                        <select id="current_operation" name="briefing[business_info][current_operation]" required>
                            <option value="">Select option...</option>
                            <option value="fully-manual">Fully manual</option>
                            <option value="partially-digital">Partially digital</option>
                            <option value="uses-software-needs-improvement">I already use software, but need to improve</option>
                            <option value="fully-digital">Fully digital</option>
                        </select>
                    </div>
                </div>
                
                <!-- Step 2: The Problem You Want to Solve -->
                <div class="form-step" data-step="2">
                    <h2 class="section-title">The Problem You Want to Solve</h2>
                    
                    <div class="form-group">
                        <label for="main_problem">What is the main problem you need to solve in your business? *</label>
                        <textarea id="main_problem" name="briefing[problem][main_problem]" required placeholder="Describe the main problem you're facing."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="what_you_tried">What have you already tried to solve this problem? *</label>
                        <textarea id="what_you_tried" name="briefing[problem][what_you_tried]" required placeholder="What solutions or approaches have you already attempted?"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="why_now">Why is now the right time to solve this? *</label>
                        <textarea id="why_now" name="briefing[problem][why_now]" required placeholder="What makes this the right moment to address this problem?"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="problem_impact">Does this problem cause losses? *</label>
                        <div class="checkbox-group">
                            <label>
                                <input type="checkbox" name="briefing[problem][problem_impact][]" value="financial">
                                Financial losses
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[problem][problem_impact][]" value="wasted-time">
                                Wasted time
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[problem][problem_impact][]" value="manual-errors">
                                Manual errors
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[problem][problem_impact][]" value="lack-of-organization">
                                Lack of organization
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[problem][problem_impact][]" value="other">
                                Other
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="problem_affects">Briefly explain how this problem affects your daily operations. *</label>
                        <textarea id="problem_affects" name="briefing[problem][problem_affects]" required placeholder="How does this problem impact your day-to-day business operations?"></textarea>
                    </div>
                </div>
                
                <!-- Step 3: About the Desired Project -->
                <div class="form-step" data-step="3">
                    <h2 class="section-title">About the Desired Project</h2>
                    
                    <div class="form-group">
                        <label for="essential_features">What features do you consider essential? *</label>
                        <textarea id="essential_features" name="briefing[project][essential_features]" required placeholder="List the features that are absolutely necessary for your project."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="reference_models">Do you have any reference models? (websites, systems, apps, screenshots, videos)</label>
                        <textarea id="reference_models" name="briefing[project][reference_models]" placeholder="If you have examples of similar systems or features you like, please share them here. You can include links, descriptions, or screenshots."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="integrations">Should the system integrate with anything? *</label>
                        <div class="checkbox-group">
                            <label>
                                <input type="checkbox" name="briefing[project][integrations][]" value="whatsapp">
                                WhatsApp
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[project][integrations][]" value="online-payments">
                                Online payments
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[project][integrations][]" value="google-calendar">
                                Google Calendar
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[project][integrations][]" value="internal-systems">
                                Internal systems
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[project][integrations][]" value="spreadsheets">
                                Spreadsheets
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[project][integrations][]" value="external-api">
                                External API
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[project][integrations][]" value="not-sure-need-help">
                                I don't know / I need help
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[project][integrations][]" value="other">
                                Other
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="integration_details">If you selected any integration above, please provide more details (Optional)</label>
                        <textarea id="integration_details" name="briefing[project][integration_details]" placeholder="Tell us more about the integration you need."></textarea>
                    </div>
                </div>
                
                <!-- Step 4: Maturity, Intention and Way of Working -->
                <div class="form-step" data-step="4">
                    <h2 class="section-title">Timeline, Budget & Project Details</h2>
                    
                    <div class="form-group">
                        <label for="budget_reserved">Do you already have a budget reserved for this project? *</label>
                        <p class="help-text">This allows me to think on minimal features to match your budget</p>
                        <select id="budget_reserved" name="briefing[timeline_budget][budget_reserved]" required>
                            <option value="">Select option...</option>
                            <option value="yes-amount">Yes → I have an amount</option>
                            <option value="yes-range">I have a budget range</option>
                            <option value="researching">I'm researching</option>
                            <option value="just-curious">Just curious</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="budget_amount_group" style="display: none;">
                        <label for="budget_amount">What is your budget amount or range?</label>
                        <input type="text" id="budget_amount" name="briefing[timeline_budget][budget_amount]" placeholder="e.g., $15,000 or $10,000 - $20,000">
                    </div>
                    
                    <div class="form-group">
                        <label for="urgency">What is the urgency of the project? *</label>
                        <select id="urgency" name="briefing[timeline_budget][urgency]" required>
                            <option value="">Select option...</option>
                            <option value="this-month">I want to start this month</option>
                            <option value="next-quarter">Next quarter</option>
                            <option value="no-deadline">No defined deadline</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="why_important">Why is this project important to you now? *</label>
                        <textarea id="why_important" name="briefing[timeline_budget][why_important]" required placeholder="What makes this the right time for this project?"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="can_participate">Can you actively participate in the development? (answering questions, approving screens, etc.) *</label>
                        <select id="can_participate" name="briefing[timeline_budget][can_participate]" required>
                            <option value="">Select option...</option>
                            <option value="yes-daily">Yes, daily</option>
                            <option value="yes-few-times-week">Yes, a few times per week</option>
                            <option value="difficult-to-follow">Difficult to follow</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="prefer_meetings">Do you prefer meetings during development? *</label>
                        <select id="prefer_meetings" name="briefing[timeline_budget][prefer_meetings]" required>
                            <option value="">Select option...</option>
                            <option value="yes-periodic">Yes, periodic meetings</option>
                            <option value="only-when-needed">Only when necessary</option>
                            <option value="no-meetings">I don't need meetings</option>
                        </select>
                    </div>
                </div>
                
                <!-- Step 5: Existing Materials and Structure -->
                <div class="form-step" data-step="5">
                    <h2 class="section-title">Existing Materials and Structure</h2>
                    
                    <div class="form-group">
                        <label for="existing_materials">Do you already have: *</label>
                        <div class="checkbox-group">
                            <label>
                                <input type="checkbox" name="briefing[materials][logo]" value="1">
                                Logo
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[materials][visual_identity]" value="1">
                                Visual Identity
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[materials][domain]" value="1">
                                Domain
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[materials][hosting]" value="1">
                                Hosting
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[materials][texts_images]" value="1">
                                Texts and Images
                            </label>
                            <label>
                                <input type="checkbox" name="briefing[materials][none]" value="1">
                                None of these
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="domain_name">If you already have a domain, what is it?</label>
                        <input type="text" id="domain_name" name="briefing[materials][domain_name]" placeholder="e.g., example.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="account_access">Do you have access to the necessary accounts? (email, social media, tools, APIs, etc.)</label>
                        <select id="account_access" name="briefing[materials][account_access]">
                            <option value="">Select option...</option>
                            <option value="yes-all">Yes, I have access to everything</option>
                            <option value="yes-some">Yes, I have access to some</option>
                            <option value="no">No, I don't have access</option>
                            <option value="not-sure">Not sure</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="existing_documents">Do you have documents, flows, or spreadsheets that explain your current process?</label>
                        <textarea id="existing_documents" name="briefing[materials][existing_documents]" placeholder="Just a quick overview to understand what you have. You don't need to describe everything in detail - I'll ask for specific details during the development phase."></textarea>
                    </div>
                </div>
                
                <!-- Step 6: Contact Info & Confirmation -->
                <div class="form-step" data-step="6">
                    <h2 class="section-title">Contact Information & Confirmation</h2>
                    
                    <div class="form-group">
                        <label for="preferred_contact_method">Preferred method of contact?</label>
                        <select id="preferred_contact_method" name="briefing[contact_info][preferred_contact_method]">
                            <option value="">Select option...</option>
                            <option value="email">Email</option>
                            <option value="phone">Phone</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="either">Either</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="planning_to_hire">Are you planning to hire a developer in the coming weeks? *</label>
                        <select id="planning_to_hire" name="briefing[contact_info][planning_to_hire]" required>
                            <option value="">Select option...</option>
                            <option value="yes">Yes</option>
                            <option value="probably">Probably</option>
                            <option value="maybe">Maybe</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="final_delivery">Imagine your life when this software is done and working perfectly. What does your day look like? What problems are solved? What can you do that you can't do now? *</label>
                        <textarea id="final_delivery" name="briefing[contact_info][final_delivery]" required placeholder="Paint a picture of your ideal day with this software running. What would make you say 'this is exactly what I needed'?"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="additional_info">Is there any other important information you'd like to include?</label>
                        <textarea id="additional_info" name="briefing[contact_info][additional_info]" placeholder="Any other details that might be helpful for us to understand your project better."></textarea>
                    </div>
                </div>
                
                <!-- Navigation Buttons -->
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeStep(-1)" style="display: none;">Previous</button>
                    <div style="flex: 1;"></div>
                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeStep(1)">Next</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;">Submit Briefing</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        let currentStep = 1;
        const totalSteps = 6;
        
        // Show/hide budget amount field based on selection
        document.getElementById('budget_reserved')?.addEventListener('change', function() {
            const budgetAmountGroup = document.getElementById('budget_amount_group');
            if (this.value === 'yes-amount' || this.value === 'yes-range') {
                budgetAmountGroup.style.display = 'block';
            } else {
                budgetAmountGroup.style.display = 'none';
            }
        });
        
        function updateStepDisplay() {
            // Update stepper
            document.querySelectorAll('.step').forEach((step, index) => {
                const stepNum = index + 1;
                step.classList.remove('active', 'completed');
                if (stepNum < currentStep) {
                    step.classList.add('completed');
                } else if (stepNum === currentStep) {
                    step.classList.add('active');
                }
            });
            
            // Update form steps
            document.querySelectorAll('.form-step').forEach((step, index) => {
                step.classList.remove('active');
                if (index + 1 === currentStep) {
                    step.classList.add('active');
                }
            });
            
            // Update buttons
            document.getElementById('prevBtn').style.display = currentStep === 1 ? 'none' : 'inline-block';
            document.getElementById('nextBtn').style.display = currentStep === totalSteps ? 'none' : 'inline-block';
            document.getElementById('submitBtn').style.display = currentStep === totalSteps ? 'inline-block' : 'none';
        }
        
        function changeStep(direction) {
            const newStep = currentStep + direction;
            
            if (newStep < 1 || newStep > totalSteps) {
                return;
            }
            
            // Validate current step before moving
            if (direction > 0) {
                const currentStepElement = document.querySelector(`.form-step[data-step="${currentStep}"]`);
                const requiredFields = currentStepElement.querySelectorAll('[required]');
                let isValid = true;
                
                // Check checkboxes for problem_impact and integrations
                if (currentStep === 2) {
                    const checkboxes = currentStepElement.querySelectorAll('input[name*="problem_impact"]');
                    const checked = Array.from(checkboxes).some(cb => cb.checked);
                    if (!checked) {
                        isValid = false;
                        alert('Please select at least one option for "Does this problem cause losses?"');
                        return;
                    }
                }
                
                if (currentStep === 3) {
                    const checkboxes = currentStepElement.querySelectorAll('input[name*="integrations"]');
                    const checked = Array.from(checkboxes).some(cb => cb.checked);
                    if (!checked) {
                        isValid = false;
                        alert('Please select at least one option for "Should the system integrate with anything?"');
                        return;
                    }
                }
                
                requiredFields.forEach(field => {
                    if (field.type === 'checkbox') {
                        // Skip checkbox validation here, handled above
                        return;
                    }
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = '#ff6b6b';
                    } else {
                        field.style.borderColor = '';
                    }
                });
                
                if (!isValid) {
                    alert('Please fill in all required fields before continuing.');
                    return;
                }
            }
            
            currentStep = newStep;
            updateStepDisplay();
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        // Initialize
        updateStepDisplay();
    </script>
</body>
</html>
