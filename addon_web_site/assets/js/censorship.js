// Файл проверки на цензуру текста. Unesell 2021.
function Censorship(text_box){
    var text = text_box.toLowerCase();
    // 1** слов
    if(
        //Русский язык
        text.includes('сука') || text.includes('еба') ||
        text.includes('бля') || text.includes('хуес') ||
        text.includes('блять') || text.includes('дебил') ||
        text.includes('блядь') || text.includes('дурок') ||
        text.includes('херня') || text.includes('срать') ||
        text.includes('хуй') || text.includes('жрать') ||
        text.includes('охуеть') || text.includes('манда') ||
        text.includes('блевать') || text.includes('вагина') ||
        text.includes('рыгать') || text.includes('уебан') ||
        text.includes('срать') || text.includes('пидор') ||
        text.includes('пизда') || text.includes('ёбаный') ||
        text.includes('жопа') || text.includes('хуя') ||
        text.includes('пидор') || text.includes('челен') ||
        text.includes('ебать') || text.includes('грёбаный') ||
        text.includes('буллщет') || text.includes('впизд') ||
        text.includes('выебу') || text.includes('выёбывает') ||
        text.includes('ёбнулся') || text.includes('ебашит') ||
        text.includes('говно') || text.includes('хуёво') ||
        //new
        text.includes('охуенной') || text.includes('охуеной') ||
        text.includes('мудак') || text.includes('писюн') ||
        text.includes('пенис') || text.includes('пися') ||
        // Украинский язык
        text.includes ( 'сучьонок') || text.includes ( 'єба') ||
        text.includes ( 'бля') || text.includes ( 'хуїс') ||
        text.includes ( 'блять') || text.includes ( 'дебіл') ||
        text.includes ( 'блядь') || text.includes ( 'дурок') ||
        text.includes ( 'херня') || text.includes ( 'срать') ||
        text.includes ( 'хуй') || text.includes ( 'жерти') ||
        text.includes ( 'охуеть') || text.includes ( 'манда') ||
        text.includes ( 'блювати') || text.includes ( 'вагіна') ||
        text.includes ( 'похуярити') || text.includes ( 'курва') ||
        text.includes ( 'срати') || text.includes ( 'підор') ||
        text.includes ( 'пізда') || text.includes ( 'йобаний') ||
        text.includes ( 'жопа') || text.includes ( 'хуї') ||
        text.includes ( 'пидор') || text.includes ( 'челен') ||
        text.includes ( 'їбать') || text.includes ( 'грьобан') ||
        text.includes ( 'буллщет') || text.includes ( 'впізд') ||
        text.includes ( 'виїбу') || text.includes ( 'виебиваться') ||
        text.includes ( 'їбанулся') || text.includes ( 'дегенерат') ||
        text.includes ( 'гівно') || text.includes ( 'хуйово') ||
        //Английский язык
        text.includes ('bitch') ||
        text.includes ('shit') || text.includes ('hues') ||
        text.includes ('fuck') || text.includes ('fool') ||
        text.includes ('shit') || text.includes ('shit') ||
        text.includes ('fack') || text.includes ('manda') ||
        text.includes ('puke') || text.includes ('vagina') ||
        text.includes ('burp') || text.includes ('edla') ||
        text.includes ('shit') ||
        text.includes ('pussy') || text.includes ('fucking') ||
        text.includes ('ass') || text.includes ('fuck') ||
        text.includes ('fag') || text.includes ('chelen') ||
        text.includes ('fuck') || text.includes ('fucking') ||
        text.includes ('bullshchet') || text.includes ('vpizd') ||
        text.includes ('fuck') || text.includes ('fuck it') ||
        text.includes ('fucked up') || text.includes ('ebashit') ||
        text.includes ('shit') || text.includes ('suck')
    ){
        return true; // Есть нецензурная брань.
    }else{
        return false; //Нецензурщина не найдена
    }

}

function info_censor(){
    console.log("Censorship. Unesell, version 0.0.3 beta");
}