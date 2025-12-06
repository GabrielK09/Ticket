package frontEnd

import (
	"errors"
	"fmt"
	"log"
	"os"
	"path/filepath"
)

var finalPath string = "D:\\Gabriel\\MVPs\\1\\frontend"

func checkExistEnv() (bool, error) {
	envPath := fmt.Sprintf("%s\\.env", finalPath)
	log.Println(envPath)

	_, err := os.Stat(envPath)

	if err == nil {
		log.Println("O arquivo existe: ", err)
		return true, nil
	}

	if errors.Is(err, os.ErrNotExist) {
		return false, nil
	}

	return false, err
}

func MoveFile() error {
	exists, err := checkExistEnv()

	if err != nil {
		log.Println("Erro ao validar se o arquivo existe: ", err)
		return err
	}

	if exists {
		log.Println("O arquivo existe")
		return nil

	} else {
		currentPath, err := os.Getwd()

		if err != nil {
			log.Fatalf("Erro ao pegar o caminho atual %s", err)
			return err

		}

		log.Println("O arquivo não existe, vai criar")
		fileName, err := CreateFile()

		if err != nil {
			log.Fatalf("Erro ao criar o arquivo %s", err)
			return err

		}

		log.Println("arquivo criado, vai mover ele")

		oldPath := filepath.Join(currentPath, fileName)

		newPath := filepath.Join(finalPath, fileName)

		err = os.Rename(oldPath, newPath)

		if err != nil {
			log.Fatalf("Erro ao mover o arquivo %s", err)
			return err
		}

		log.Println("Arquivo movido")

		log.Printf("Dir: %s", newPath)

		return nil
	}
}
