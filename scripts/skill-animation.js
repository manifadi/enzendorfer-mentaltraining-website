const skillButtons = document.getElementsByClassName("skill");
const skillNames = ['Neuromentaltraining','Trancearbeit', 'Rückführung', 'Humanenergetik'];
const skillTexts = [
    'Neuromentaltraining nutzt Techniken, die das Gehirn dazu anregen, neue Denk- und Verhaltensmuster zu entwickeln. Durch gezielte Übungen, Visualisierungen und Mentaltechniken wird das Unterbewusstsein angesprochen, um positive Veränderungen im Denken und Handeln zu bewirken. Dies hilft, Stress abzubauen, das Selbstbewusstsein zu stärken und Blockaden zu überwinden. Besonders geeignet ist das Training zur Verbesserung der mentalen Leistungsfähigkeit und zur Zielerreichung im Alltag und Beruf.',
    'Trancearbeit ist eine Methode, bei der durch eine tiefe Entspannung oder leichte Hypnose ein Trancezustand erreicht wird. In diesem Zustand wird das Bewusstsein reduziert, sodass das Unterbewusstsein besser zugänglich wird und Veränderungen an tief verankerten Überzeugungen oder Verhaltensmustern vorgenommen werden können. Die Vorteile liegen in der effektiven Reduzierung von Stress, der Lösung innerer Konflikte und der Verbesserung des emotionalen Wohlbefindens.',
    'Bei der Rückführung wird eine sanfte, hypnotische Technik eingesetzt, um Klienten in vergangene Erlebnisse oder in frühere Lebensphasen zu führen. Diese Methode kann dazu beitragen, unverarbeitete emotionale Erlebnisse oder Ursachen für bestimmte Ängste und Verhaltensmuster zu verstehen. Durch das Aufarbeiten dieser Erinnerungen können Blockaden gelöst und innere Ruhe sowie Klarheit im Leben erlangt werden. Besonders hilfreich ist die Rückführung für Menschen, die sich tief mit ihrer eigenen Lebensgeschichte auseinandersetzen möchten.',
    'Die Humanenergetik konzentriert sich auf die Harmonisierung der Lebensenergie durch gezielte energetische Techniken, wie das Lösen von Blockaden und die Stärkung der Energieflüsse im Körper. Dabei werden Methoden wie Energiearbeit, Chakren-Ausgleich und andere natürliche Techniken angewendet, um das Wohlbefinden zu steigern und die Selbstheilungskräfte zu aktivieren. Humanenergetik unterstützt Körper und Geist dabei, ins Gleichgewicht zu kommen und fördert innere Ruhe und Vitalität.'
]

const skillTitleHTMLElement = document.querySelector("#current-service");
const skillDescriptionHTMLElement = document.querySelector(".skill-description");
const skillInfoElement = document.querySelector('.skill-info');

document.body.onload = changeTitleAndText(0);

Array.from(skillButtons).forEach((button, index) => {
    button.addEventListener("click", () => animateChange(index));
});

function animateChange(number) {
    // Prevent clicking during animation
    if (skillTitleHTMLElement.classList.contains('animate-out')) return;

    // Animate out current content
    skillTitleHTMLElement.classList.add('animate-out');
    skillDescriptionHTMLElement.classList.add('fade-out');

    // Wait for animation to complete then update content
    setTimeout(() => {
        // Update content
        skillTitleHTMLElement.classList.add('animate-in');
        changeTitleAndText(number);

        // Remove animate-out class and trigger reflow
        skillTitleHTMLElement.classList.remove('animate-out');
        void skillTitleHTMLElement.offsetWidth; // Trigger reflow

        // Animate in new content
        skillTitleHTMLElement.classList.remove('animate-in');
        skillDescriptionHTMLElement.classList.remove('fade-out');
    }, 400); // Match this with your CSS transition duration
}

function changeTitleAndText(number) {
    skillTitleHTMLElement.innerHTML = skillNames[number];
    skillDescriptionHTMLElement.innerHTML = skillTexts[number];
    Array.from(skillButtons).forEach((button, index) => {
        button.classList.toggle("active", index == number);
    });
}