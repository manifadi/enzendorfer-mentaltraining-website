const skillButtons = document.getElementsByClassName("skill");
const skillNames = ['Neuromentaltraining','Trancearbeit', 'Rückführung', 'Humanenergetik'];
const skillTexts = [
    'Neuromentaltraining ist eine innovative Methode, die darauf abzielt, das geistige Potenzial zu aktivieren und nachhaltig zu stärken. Mit gezielten Übungen und Techniken werden Denk- und Verhaltensmuster aufgebrochen und in positive, förderliche Strukturen transformiert, um persönliche Ziele effektiver zu erreichen. Durch die Ansprache des Unterbewusstseins wird nicht nur Stress abgebaut, sondern auch das Selbstbewusstsein gestärkt und Blockaden gelöst. Das Training eignet sich besonders zur Steigerung der mentalen Stärke, zur Förderung von Wohlbefinden und Zielstrebigkeit – sowohl im beruflichen als auch im privaten Bereich.',
    'Trancearbeit ist eine Methode, die durch tiefe Entspannung oder leichte Hypnose einen Zustand der Trance erreicht. In diesem Zustand tritt das bewusste Denken in den Hintergrund, sodass das Unterbewusstsein besser zugänglich wird und tief verwurzelte Überzeugungen oder Verhaltensmuster leichter verändert werden können. Die Vorteile dieser Technik liegen in der wirkungsvollen Reduktion von Stress, der Lösung innerer Konflikte und der Förderung des emotionalen Wohlbefindens.',
    'Die Rückführung ist eine sanfte Methode, die mittels hypnotischer Techniken Zugang zu vergangenen Erlebnissen oder früheren Lebensphasen ermöglicht. Diese Reise in die Vergangenheit kann helfen, unbewusste Blockaden und emotionale Wunden aufzudecken und tiefere Zusammenhänge für aktuelle Ängste oder Verhaltensmuster zu verstehen. Indem solche Erinnerungen bewusst aufgearbeitet werden, entsteht oft ein Gefühl der inneren Befreiung und Klarheit, das mehr Ruhe und Ausgeglichenheit im Alltag fördert. Die Rückführung eignet sich besonders für Menschen, die ihre persönliche Geschichte erkunden und ein tieferes Verständnis für ihr Leben entwickeln möchten.',
    'Die Humanenergetik zielt darauf ab, die Lebensenergie in harmonischen Fluss zu bringen und innere Blockaden sanft aufzulösen. Durch energetische Techniken wie Chakren-Ausgleich und gezielte Energiearbeit wird das natürliche Gleichgewicht von Körper und Geist unterstützt, was zu einer Steigerung des Wohlbefindens und der Aktivierung der Selbstheilungskräfte führt. Diese Methode fördert eine tiefgreifende innere Ruhe, stärkt die Vitalität und hilft, den Alltag mit neuer Energie und Ausgeglichenheit zu meistern.'
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